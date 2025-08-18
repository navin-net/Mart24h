<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // List of realistic product names inspired by brands
        $productNames = [
            'iPhone 14 Pro',
            'MacBook Air M2',

            'MSI Katana GF76'
        ];

        // Seed 10 product records
        for ($i = 1; $i <= 3; $i++) {
            // Randomly select a product name
            $name = $productNames[array_rand($productNames)];
            // Generate a unique code
            $code = 'P' . str_pad($i, 3, '0', STR_PAD_LEFT);
            // Random stock, cost, and selling price
            $stock = rand(20, 200);
            $costPrice = round(rand(300, 1000) + (rand(0, 99) / 100), 2); // $300.00 - $1000.99
            $sellingPrice = round($costPrice * (1 + rand(20, 50) / 100), 2); // 20-50% markup

            Products::create([
                'name' => $name,
                'code' => $code,
                'description' => "High-performance $name with advanced features.",
                'stock_quantity' => $stock,
                'cost_price' => $costPrice,
                'selling_price' => $sellingPrice,
                'brand_id' => 1,
                'category_id' => 1,
                'subcategory_id' => 1,
                'quality_id' => 1
            ]);
        }
    }
}
