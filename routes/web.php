<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\PurchasesController;
use App\Http\Controllers\Admin\QualitysController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\MainController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/empty_page', function () {
    return view('empty_page');
});


Route::get('testing', function () {
    return view('testing');
});



Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::get('/pos/search', [PosController::class, 'search'])->name('pos.search');
Route::get('/pos/filter', [PosController::class, 'filter'])->name('pos.filter');
Route::post('/pos/process-payment', [PosController::class, 'processPayment'])->name('pos.process-payment');
Route::get('/pos/customer-display', [PosController::class, 'customerDisplay'])->name('admin.customer-display');

Route::get('/', [MainController::class, 'index']);
// web.php
Route::get('shop/products', [MainController::class, 'products'])->name('shop.products');
Route::get('/product-detail/{id}', [MainController::class, 'productDetail'])->name('shop.productDetail');
Route::get('shop/about', [MainController::class, 'about'])->name('shop.about');
Route::get('shop/checkout',[MainController::class,'checkout'])->name('shop.checkout');
Route::get('shop/cart', [MainController::class, 'cart'])->name('shop.cart');
Route::get('shop/contact', [MainController::class, 'contact'])->name('shop.contact');
Route::get('shop/new-arrivals',[MainController::class,'new_arrivals'])->name('shop.new-arrivals');
Route::get('/product-alerts', [AuthController::class, 'getAlerts']);


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin', [AuthController::class, 'login'])
    ->middleware('throttle:3,1') // 3 attempts in 3 minutes
    ->name('admin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::middleware('auth')->group(function () {

    Route::get('/users/{id}/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/users/{id}/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('purchases', PurchasesController::class)->except(['show']);
    Route::post('purchases/bulk-delete', [PurchasesController::class, 'bulkDelete'])->name('purchases.bulkDelete');
    Route::get('purchases/export', [PurchasesController::class, 'export'])->name('purchases.export');
    Route::get('/purchases/getData', [PurchasesController::class, 'getData'])->name('purchases.getData');
    Route::get('/purchases/show', [PurchasesController::class, 'show'])->name('purchases.show');
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/getData', [ProductController::class, 'getData'])->name('products.getData');
    Route::get('/products/show/{id}',[ProductController::class,'show'])->name('products.show');
    Route::get('/products/subcategories', [ProductController::class, 'getSubCategories'])->name('products.subcategories');

    Route::resource('/brands', BrandController::class)->except(['show']);
    Route::get('/brands/export', [BrandController::class, 'export'])->name('brands.export');
    Route::post('brands/bulkDelete', [BrandController::class, 'bulkDelete'])->name('brands.bulkDelete');
    Route::resource('/qualitys', QualitysController::class)->parameters(['qualitys' => 'qualitys'])->except(['show']);
    Route::delete('/qualitys/bulk-delete', [QualitysController::class, 'bulkDelete'])->name('qualitys.bulkDelete');
    # categories
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::post('/categories/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('categories.bulkDelete');
    Route::get('/categories/sub_category', [CategoriesController::class, 'sub_category'])->name('categories.sub_category');
    Route::post('/categories/sub_category/store', [CategoriesController::class, 'store_sub_category'])->name('categories.sub_category.store');
    Route::get('/categories/sub_category/{id}/edit', [CategoriesController::class, 'edit_sub_category'])->name('categories.sub_category.edit');
    Route::post('/categories/sub_category/{id}/update', [CategoriesController::class, 'update_sub_category'])->name('categories.sub_category.update');
    Route::delete('/categories/sub_category/{id}/delete', [CategoriesController::class, 'delete_sub_category'])->name('categories.sub_category.delete');
    Route::post('/categories/sub_category/bulk-delete', [CategoriesController::class, 'bulkDeleteSubCategories'])->name('categories.sub_category.bulkDelete');



    Route::resource('/sales', SalesController::class)->except(['show']);
    // Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('/sales/getData', [SalesController::class, 'getData'])->name('sales.getData');
    Route::post('/sales/bulk-delete', [SalesController::class, 'bulkDelete'])->name('sales.bulkDelete');
    Route::get('/sales/export', [SalesController::class, 'export'])->name('sales.export');
    Route::get('/sales/detail/{id}', [SalesController::class, 'show'])->name('sales.show');

    ///Settings
    Route::resource('/settings', SettingsController::class)->except(['show']);
    Route::get('settings/banners', [SettingsController::class, 'banners'])->name('settings.banners');
    Route::post('/banner/ajax-update-all', [SettingsController::class, 'ajaxUpdateAll'])->name('banners.ajaxUpdateAll');
    Route::post('/settings/update', [SettingsController::class, 'ajaxUpdate'])->name('settings.update');



});


///lang
Route::get('/switch-language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
