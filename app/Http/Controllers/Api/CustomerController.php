<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index(){
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        
        $query = Customer::query()
        ->where('status', 'active')
        ->orderBy("customers.$sortField", $sortDirection);
        $paginator = $query->paginate($perPage);

        return CustomerListResource::collection($paginator);
    }

    public function show(Customer $customer){
        return new CustomerResource($customer);
    }

    public function update(CustomerRequest $request, Customer $customer){
        $customerData = $request->validated();
        $customerData['updated_by'] = $request->user()->id;
        $customerData['status'] = $customerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
        $shippingData = $customerData['shippingAddress'];
        $billingData = $customerData['billingAddress'];

        DB::beginTransaction();
        try {
            $customer->update($customerData);

            if ($customer->shippingAddress) {
                $customer->shippingAddress->update($shippingData);
            } else {
                $shippingData['customer_id'] = $customer->user_id;
                $shippingData['type'] = AddressType::Shipping->value;
                CustomerAddress::create($shippingData);
            }

            if ($customer->billingAddress) {
                $customer->billingAddress->update($billingData);
            } else {
                $billingData['customer_id'] = $customer->user_id;
                $billingData['type'] = AddressType::Billing->value;
                CustomerAddress::create($billingData);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            Log::critical(__METHOD__ . ' method does not work. '. $e->getMessage());
            throw $e;
        }

        DB::commit();

        return new CustomerResource($customer);
    }
    
    public function destroy(Customer $customer){
        $customer->delete();
        return response()->noContent();
    }

    public function countries(){
        return CountryResource::collection(Country::query()->orderBy('name', 'asc')->get());
    }
}
