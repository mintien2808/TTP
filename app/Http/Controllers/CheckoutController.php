<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Mail\NewOrderEmail;
use App\Mail\PaymentFailEmail;
use App\Models\Country;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function checkout(Request $request) {
        [$products, $cartItems] = Cart::getProductsAndCartItems();
        $total = 0;
    
        foreach ($products as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }
    
        $user = $request->user();
        $customer = $user->customer;
    
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type' => 'Billing']);
        
        $countries = Country::all();
        

        foreach ($countries as $country) {
            $country->states = json_decode($country->states, true); 
        }
    
        $currentStates = [];
        if ($billingAddress->country_code) {
            $currentCountry = $countries->firstWhere('code', $billingAddress->country_code);
            $currentStates = $currentCountry ? $currentCountry->states : [];
        }
        
        return view('checkout.index', compact('cartItems', 'products', 'total', 'customer', 'user', 'billingAddress', 'countries', 'currentStates'));
    }
    

    public function process(CheckoutRequest $request){
        $data = $request->validated();
        
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh Toán Đơn Hàng Của Bạn Tại TTP";
        $amount = $data['total'];
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/checkout/thanks";
        $ipnUrl = "http://127.0.0.1:8000/payment_ipn";
        $extraData =  $data['phone']. "," . $data['address1'] . "," . $data['country_code']   . "," . $data['states'] . "," . $data['first_name'] . "," . $data['last_name'];
    
        $requestId = time() . "";
        $requestType = "payWithATM";
    
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];
    
        $result = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($endpoint, $data);
    
        $jsonResult = $result->json();  
    
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']); 
        } else {
            return redirect()->back()->withErrors(['msg' => 'Có lỗi xảy ra khi kết nối với MoMo.']);
        }
    }

    public function execPostRequest($url, $data){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function thanks(Request $request){
        $orderId = $request->query('orderId');
        $status = $request->query('resultCode');

        if ( $status === '1006') {
           return view('checkout.fail');
        }else{

        $user = $request->user();

            if($user){
                $customer = $user->customer;

                $order = new Order();
                $order->id = $request->query('orderId');
                $order->status = OrderStatus::Completed->value;
                [$products, $cartItems] = Cart::getProductsAndCartItems();

                $totalAmount = 0;
                foreach ($products as $product) {
                    $totalAmount += $product->price * $cartItems[$product->id]['quantity'];
                }

                $order->total_price = $totalAmount;
                $order->created_by = $user->id;
                $order->save();

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->quantity = $cartItems[$product->id]['quantity'];
                $orderItem->unit_price = $product->price * $cartItems[$product->id]['quantity'];
                $orderItem->save();

                $orderDetails = new OrderDetails();
                $orderDetails->order_id = $order->id;
                $orderDetails->first_name = $customer->first_name;
                $orderDetails->last_name = $customer->last_name;
                $orderDetails->phone = $request->phone;
                $orderDetails->address1 = $request->address1;
                $orderDetails->city = $request->countries;
                $orderDetails->states = $request->states;
                
                $orderDetails->save();

                $cartItem = CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first();
                if ($cartItem) {
                    $cartItem->delete();
                }
                Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
            }
            return view('checkout.thanks')->with('orderId', $orderId);
        }
    }
    
}