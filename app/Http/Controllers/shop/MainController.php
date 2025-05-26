<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        return view('shop.index');
    }

    public function about()
    {
        return view('shop.about');
    }

    public function contact()
    {
        return view('shop.contact');
    }
public function products()
{
    $products = [ /* same static array from above */ ];
    return view('shop.products', compact('products'));
}

public function productDetail($id)
{
    $products = [
        [
            'id' => 0,
            'name' => 'Smart Watch Pro',
            'image' => asset('storage/banners/2lFTJbvF7lfuDzJ05qgXtLRpIYSbxYCJeD9nNYvA.jpg'),
            'price' => 149.99,
            'old_price' => 199.99,
            'rating' => 4,
            'badge' => 'Sale',
            'badge_class' => 'bg-danger',
            'description' => 'Stay connected with the Smart Watch Pro, featuring health tracking and notifications.',
        ],
        [
            'id' => 1,
            'name' => 'Wireless Headphones',
            'image' => 'https://via.placeholder.com/300x200?text=Headphones',
            'price' => 89.99,
            'old_price' => null,
            'rating' => 5,
            'badge' => null,
            'badge_class' => null,
            'description' => 'Experience immersive sound with noise-cancelling wireless headphones.',
        ],
        [
            'id' => 2,
            'name' => 'Running Shoes',
            'image' => 'https://via.placeholder.com/300x200?text=Shoes',
            'price' => 129.99,
            'old_price' => null,
            'rating' => 4,
            'badge' => null,
            'badge_class' => null,
            'description' => 'Comfortable and durable running shoes for all terrains.',
        ],
        [
            'id' => 3,
            'name' => 'Gaming Laptop X200',
            'image' => 'https://via.placeholder.com/300x200?text=Gaming+Laptop',
            'price' => 1499.00,
            'old_price' => 1799.00,
            'rating' => 5,
            'badge' => 'New',
            'badge_class' => 'bg-success',
            'description' => 'High-performance laptop designed for gaming and multitasking.',
        ],
    ];

    $product = collect($products)->firstWhere('id', $id);

    if (!$product) {
        abort(404);
    }

    return view('shop.product_detail', compact('product'));
}






}
