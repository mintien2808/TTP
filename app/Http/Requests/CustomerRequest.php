<?php

namespace App\Http\Requests;

use App\Enums\CustomerStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required', 'min:7'],
            'email' => ['required', 'email'],
            'status' => ['required', 'boolean'],

            'shippingAddress.address1' => ['required'],
            'shippingAddress.address2' => ['required'],
            'shippingAddress.state' => ['required'],
            'shippingAddress.zipcode' => ['required'],
            'shippingAddress.country_code' => ['required', 'exists:countries,code'],

            'billingAddress.address1' => ['required'],
            'billingAddress.address2' => ['required'],
            'billingAddress.state' => ['required'],
            'billingAddress.zipcode' => ['required'],
            'billingAddress.country_code' => ['required', 'exists:countries,code'],

        ];
    }

    public function attributes()
    {
        return [
            'billingAddress.address1' => 'address 1',
            'billingAddress.address2' => 'address 2',
            'billingAddress.state' => 'state',
            'billingAddress.zipcode' => 'zip code',
            'billingAddress.country_code' => 'country',
            'shippingAddress.address1' => 'address 1',
            'shippingAddress.address2' => 'address 2',
            'shippingAddress.state' => 'state',
            'shippingAddress.zipcode' => 'zip code',
            'shippingAddress.country_code' => 'country',
        ];
    }
}
