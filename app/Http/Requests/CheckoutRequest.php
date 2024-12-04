<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],  
            'address1' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'total' => ['required', 'numeric'],
            'countries' => ['required'],
            'states' => ['required'],
        ];
    }
    
}
