<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function create(){
        return view('auth.register');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            event(new Registered($user));
            
            $customer = new Customer();
            $names = explode(" ", $user->name);
            $customer->user_id = $user->id;
            $customer->first_name = $names[0];
            $customer->last_name = $names[1] ?? '';
            $customer->status = 'disabled';
            $customer->save();

            Auth::login($user);

        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
        
        DB::commit();

        Cart::moveCartItemsIntoDb();

        return redirect('/');
    }
}
