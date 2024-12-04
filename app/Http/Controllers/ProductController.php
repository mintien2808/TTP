<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Helpers\PriceHelper;


class ProductController extends Controller
{
    public function index(){
        $query = Product::query();
        return $this->renderProducts($query);
    }

    public function byCategory(Category $category){
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        return $this->renderProducts($query);
    }

    public function view(Product $product){
        $reviews = ProductReview::query()
            ->where('product_id', $product->id)
            ->get();
        return view('product.view', compact('product', 'reviews'));
    }

    private function renderProducts(Builder $query){
        $search = \request()->get('search');
        $sort = \request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);

            $query->orderBy($sortField, $sortDirection);
        }
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })

            ->paginate(8);

        return view('product.index', [
            'products' => $products
        ]);

    }
}
