<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Categories;
use App\Models\ProductImage;
use App\Models\PurchaseItem;
use App\Models\Qualitys;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'stock_quantity',
        'expiry_date',
        'cost_price',
        'selling_price',
        'image', // main image (optional if you use gallery)
        'brand_id',
        'category_id',
        'subcategory_id',
        'quality_id',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function quality()
    {
        return $this->belongsTo(Qualitys::class);
    }

public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}



}
