<?php

namespace App\Http\Requests\Auth;

use App\Enums\CustomerStatus;
use App\Models\Customer;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(){

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = $this->user();
        $customer = $user->customer;
        if ($customer->status != CustomerStatus::Active->value) {
            Auth::guard('web')->logout();
            $this->session()->invalidate();
            $this->session()->regenerateToken();
            throw ValidationException::withMessages([
                'email' => 'Tài khoản của bạn đã bị khoá. Vui lòng liên hệ với admin.',
            ]);
        }
    }
}
