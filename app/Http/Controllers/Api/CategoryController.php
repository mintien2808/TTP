<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index(){
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $categories = Category::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();

        return CategoryResource::collection($categories);
    }
    public function getAsTree(){
        return Category::getActiveAsTree(CategoryTreeResource::class);
    }

    public function store(StoreCategoryRequest $request){
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $category->update($data);

        return new CategoryResource($category);
    }
}
