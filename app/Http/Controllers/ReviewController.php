<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Http\Requests\Reviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function store(Reviews $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        ProductReview::create($validated);
        return redirect()->route('product.view');
    }

    public function update(Request $request, ProductReview $review)
    {
        $validated = $request->validate([
            'review' => 'required'
        ]);
        $validated['user_id'] = Auth::user()->id;
        $review->update($validated);
        return redirect()->route('product.view');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();
        return redirect()->route('product.view');
    }
}
