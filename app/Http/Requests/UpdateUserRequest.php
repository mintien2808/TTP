<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'name' => ['max:55'],
            'email' => ['email'],
            'password' => ['nullable', Password::min(8)->numbers()->letters()->symbols()]
        ];
    }
}
