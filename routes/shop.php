<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\MainController;

// Route::get('/', [MainController::class, 'index']);
Route::get('shop/products', [MainController::class, 'products'])->name('shop.products');
Route::get('/product-detail/{id}', [MainController::class, 'productDetail'])->name('shop.productDetail');
Route::get('shop/about', [MainController::class, 'about'])->name('shop.about');
Route::get('shop/checkout', [MainController::class, 'checkout'])->name('shop.checkout');
Route::get('shop/cart', [MainController::class, 'cart'])->name('shop.cart');
Route::get('shop/contact', [MainController::class, 'contact'])->name('shop.contact');
Route::get('shop/new-arrivals', [MainController::class, 'new_arrivals'])->name('shop.new-arrivals');
