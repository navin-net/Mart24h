<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Categories; // Use plural model name
use App\Models\Qualitys;
use App\Models\SubCategory;
use App\Models\Products;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Insert brand
        $brand = Brand::create([
            'name' => 'Brand A',
            'code' => 'A001',
            'image' => 'brand_a.jpg',
            'slug' => 'brand-a',
            'description' => 'Description of Brand A'
        ]);

        // Insert category
        $category = Categories::create([
            'name' => 'Category X',
            'slug' => 'Categoryx'
        ]);

        // Insert subcategory
        $subcategory = Subcategory::create([
            'category_id' => 1,
            'name' => 'Subcategory Y',
            'description' => 'Description of Subcategory Y'
        ]);

        // Insert quality
        $quality = Qualitys::create([
            'name' => 'High',
            'description' => 'High quality product'
        ]);

        // Insert product
        $product = Products::create([
            'name' => 'Product 1',
            'sku' => 'P001',
            'description' => 'Description of Product 1',
            'stock_quantity' => 100,
            'cost_price' => 50.00,
            'selling_price' => 75.00,
            'brand_id' => 1,
            'category_id' => 1,
            'subcategory_id' => 1,
            'quality_id' => 1
        ]);
    }
}
