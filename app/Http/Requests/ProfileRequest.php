<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required', 'min:10'],
            'email' => ['required', 'email'],

            'shipping.address1' => ['nullable', 'string'],
            'shipping.address2' => ['nullable', 'string'],
            'shipping.state' => ['nullable', 'string'],
            'shipping.zipcode' => ['nullable', 'string'],
            'shipping.country_code' => ['nullable', 'string'],
    
            'billing.address1' => ['nullable', 'string'],
            'billing.address2' => ['nullable', 'string'],
            'billing.state' => ['nullable', 'string'],
            'billing.zipcode' => ['nullable', 'string'],
            'billing.country_code' => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'billing.address1' => 'address 1',
            'billing.address2' => 'address 2',
            'billing.state' => 'state',
            'billing.zipcode' => 'zip code',
            'billing.country_code' => 'country',
            'shipping.address1' => 'address 1',
            'shipping.address2' => 'address 2',
            'shipping.state' => 'state',
            'shipping.zipcode' => 'zip code',
            'shipping.country_code' => 'country',
        ];
    }
}
