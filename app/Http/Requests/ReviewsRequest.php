<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use APP\Models\Product;
use App\Models\User;

class ReviewsRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [
            'product_id' => ['required', 'exists:products,id'],
            'user_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ];
    }
}
