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

    public function new_arrivals()
    {
        return view('shop.new_arrivals');
    }

    private function getProducts()
    {
        return [
            [
                'id' => 0,
                'name' => 'Smart Watch Pro',
                'image' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpTZWkh7Icj3SBeB9SoE_i62ZPGNKZnlZQRQ&s'
                ],
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
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW1yhlTpkCnujnhzP-xioiy9RdDQkKLMnMSg&s',
                'images' => [
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW1yhlTpkCnujnhzP-xioiy9RdDQkKLMnMSg&s',
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhAcdu3TtqXmPYhkd5mJbEjJKZPQJ7n5EQ8A&s',
                    'https://images.unsplash.com/photo-1559163499-413811fb2344?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwcm9maWxlLXBhZ2V8MXx8fGVufDB8fHx8fA%3D%3D',
                ],
                'price' => 89.99,
                'old_price' => null,
                'rating' => 5,
                'badge' => null,
                'badge_class' => null,
                'description' => 'Experience immersive sound with noise-cancelling wireless headphones.',
            ],
        ];
    }



    public function products()
    {
        $products = $this->getProducts();

        return view('shop.products', compact('products'));
    }

     public function productDetail($id)
    {
        $products = $this->getProducts();
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        $thumbnails = collect($product['images'])->map(function ($img, $i) use ($product) {
            return (object) [
                'image' => $img,
                'thumbnail' => $img,
                'alt_text' => $product['name'] . ' - View ' . ($i + 1)
            ];
        })->all();

        $product = (object) array_merge($product, [
            'main_image' => $product['image'],
            'thumbnails' => $thumbnails,
            'availability' => 'In Stock',
            'seller' => 'Sample Seller',
            'badge' => $product['badge'] ?? null,
        ]);

        return view('shop.product-detail', compact('product'));
    }

}
