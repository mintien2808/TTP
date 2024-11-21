<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Api\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProductListResource::collection($query);
    }

    public function store(ProductRequest $request){
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $categories = $data['categories'] ?? [];


        $product = Product::create($data);

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);

        return new ProductResource($product);
    }

    public function show(Product $product){
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product){
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $categories = $data['categories'] ?? [];

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);
        if (count($deletedImages) > 0) {
            $this->deleteImages($deletedImages, $product);
        }

        $product->update($data);

        return new ProductResource($product);
    }

    public function destroy(Product $product){
        $product->delete();

        return response()->noContent();
    }

    private function saveCategories($categoryIds, Product $product){
        ProductCategory::where('product_id', $product->id)->delete();
        $data = array_map(fn($id) => (['category_id' => $id, 'product_id' => $product->id]), $categoryIds);

        ProductCategory::insert($data);
    }

    private function saveImages($images, $positions, Product $product){
        foreach ($positions as $id => $position) {
            ProductImage::query()
                ->where('id', $id)
                ->update(['position' => $position]);
        }

        foreach ($images as $id => $image) {
            $path = 'images/' . Str::random();

            if (!Storage::exists('public/' . $path)) {
                Storage::makeDirectory('public/' . $path, 0755, true);
            }

            $name = Str::random() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('public/' . $path, $name);

            if (!$storedPath) {
                throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            }

            $relativePath = str_replace('public/', '', $storedPath);
            $publicUrl = Storage::url($relativePath);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $relativePath,
                'url' => URL::to($publicUrl),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1,
            ]);
        }
    }


    private function deleteImages($imageIds, Product $product){
        $images = ProductImage::query()
            ->where('product_id', $product->id)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            if ($image->path) {
                Storage::deleteDirectory('/public/' . dirname($image->path));
            }
            $image->delete();
        }
    }
}
