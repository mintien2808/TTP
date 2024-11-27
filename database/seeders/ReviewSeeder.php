<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{

    public function run(): void
    {
        $productId = 1;
        $userId = 4;
        for ($i = 0; $i < 3; $i++) {
            ProductReview::create([
                'product_id' => $productId, // Sản phẩm cố định
                'user_id' => $userId,  
                'rating' => rand(1, 5),
                'comment' => 'This is a sample comment for review #' . ($i + 1),
            ]);
        }
    }
}
