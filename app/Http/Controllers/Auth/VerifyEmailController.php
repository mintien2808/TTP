<?php

namespace App\Http\Controllers\Auth;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
 
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home', ['verified' => true]);
        }

        if ($request->user()->markEmailAsVerified()) {
            $customer = $request->user()->customer;
            $customer->status = CustomerStatus::Active->value;
            $customer->save();
        }
        
        return redirect()->route('home', ['verified' => true]);
    }
}
