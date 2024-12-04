<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Http\Requests\ReviewsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewsRequest $request){
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);
        ProductReview::create($validated);
        return redirect()->route('product.view', $product->slug);
    }


    public function destroy(ProductReview $review)
    {
        $product = $review->product; 
        $review->delete();
        
        return redirect()->route('product.view', $product->slug)->with('message', 'Đánh giá đã được xóa.');
    }
    
}
