<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{
    BannerController,
    BrandController,
    CategoriesController,
    ProductController,
    PurchasesController,
    QualitysController,
    UnitsController,
    SalesController,
    SettingsController,
    SubCategoryController,
    UserController,
    BillerController,
    WarehouseController,
    GroupsController,
    ReportController
};
// Route::middleware('auth')
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/users/{id}/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/users/{id}/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Purchases
    Route::resource('purchases', PurchasesController::class)->except(['show']);
    Route::post('purchases/bulk-delete', [PurchasesController::class, 'bulkDelete'])->name('purchases.bulkDelete');
    Route::get('purchases/export', [PurchasesController::class, 'export'])->name('purchases.export');
    Route::get('/purchases/getData', [PurchasesController::class, 'getData'])->name('purchases.getData');
    Route::get('/purchases/show', [PurchasesController::class, 'show'])->name('purchases.show');

    // Products
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/getData', [ProductController::class, 'getData'])->name('products.getData');
    Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/subcategories', [ProductController::class, 'getSubCategories'])->name('products.subcategories');
    Route::delete('/products/images/{id}', [ProductController::class, 'removeImage'])->name('products.images.remove');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');

    // Brands
    Route::resource('brands', BrandController::class)->except(['show']);
    Route::get('/brands/export', [BrandController::class, 'export'])->name('brands.export');
    Route::post('brands/bulkDelete', [BrandController::class, 'bulkDelete'])->name('brands.bulkDelete');

    // Qualitys
    Route::resource('qualitys', QualitysController::class)->except(['show']);
    Route::delete('/qualitys/bulk-delete', [QualitysController::class, 'bulkDelete'])->name('qualitys.bulkDelete');

    // Units
    Route::resource('units', UnitsController::class)->except(['show']);
    Route::post('units/bulkDelete', [UnitsController::class, 'bulkDelete'])->name('units.bulkDelete');

    // Categories
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::post('/categories/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('categories.bulkDelete');
    Route::get('/categories/sub_category', [CategoriesController::class, 'sub_category'])->name('categories.sub_category');
    Route::post('/categories/sub_category/store', [CategoriesController::class, 'store_sub_category'])->name('categories.sub_category.store');
    Route::get('/categories/sub_category/{id}/edit', [CategoriesController::class, 'edit_sub_category'])->name('categories.sub_category.edit');
    Route::post('/categories/sub_category/{id}/update', [CategoriesController::class, 'update_sub_category'])->name('categories.sub_category.update');
    Route::delete('/categories/sub_category/{id}/delete', [CategoriesController::class, 'delete_sub_category'])->name('categories.sub_category.delete');
    Route::post('/categories/sub_category/bulk-delete', [CategoriesController::class, 'bulkDeleteSubCategories'])->name('categories.sub_category.bulkDelete');

    // Sales
    Route::resource('sales', SalesController::class)->except(['show']);
    Route::get('/sales/getData', [SalesController::class, 'getData'])->name('sales.getData');
    Route::post('/sales/bulk-delete', [SalesController::class, 'bulkDelete'])->name('sales.bulkDelete');
    Route::get('/sales/export', [SalesController::class, 'export'])->name('sales.export');
    Route::get('/sales/detail/{id}', [SalesController::class, 'show'])->name('sales.show');

    // Settings
    Route::resource('settings', SettingsController::class)->except(['show']);
    Route::get('settings/banners', [SettingsController::class, 'banners'])->name('settings.banners');
    Route::post('/banner/ajax-update-all', [SettingsController::class, 'ajaxUpdateAll'])->name('banners.ajaxUpdateAll');
    Route::post('/settings/update', [SettingsController::class, 'ajaxUpdate'])->name('settings.update');
    Route::resource('warehouse',WarehouseController::class)->except(['show']);
    Route::resource('groups',GroupsController::class)->except(['show']);
    Route::post('groups/bulkDelete', [GroupsController::class, 'bulkDelete'])->name('groups.bulkDelete');

    // Users & Billers
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('billers', BillerController::class)->except(['show']);
    Route::get('/billers/{id}/users', [BillerController::class, 'listUsers'])->name('billers.users');
    Route::get('/billers/{id}/users/add', [BillerController::class, 'addUser'])
        ->name('billers.users.add');
    Route::post('/billers/{id}/users/store', [BillerController::class, 'storeUser'])
        ->name('billers.users.store');
    Route::get('/billers/{id}/users/edit', [BillerController::class, 'editUser'])
        ->name('billers.users.edit');
    Route::delete('/billers/users/{id}/delete', [BillerController::class, 'deleteUser'])->name('billers.users.delete');

    // Reports

    Route::post('/product-alerts', [AuthController::class, 'setAlerts'])->name('product.alerts');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/getReport', [ReportController::class, 'getReport'])->name('reports.getReport');
    Route::get('/reports/daily', [ReportController::class, 'ReportDaily'])->name('reports.daily');

});
