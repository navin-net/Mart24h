<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\QualitysController;
use App\Http\Controllers\Admin\SettingsController;

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


Route::get('pos',function(){
    return view('pos');
});

Route::get('/', function () {
    return view('hello');
})->name('hello');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:3,1') // 3 attempts in 3 minutes
    ->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::resource('/brands', BrandController::class)->except(['show']);
    Route::get('/brands/export', [BrandController::class, 'export'])->name('brands.export');
    // Route::get('/brands/getData', [BrandController::class, 'getData'])->name('brands.getData');
    Route::post('brands/bulkDelete', [BrandController::class, 'bulkDelete'])->name('brands.bulkDelete');
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::post('/categories/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('categories.bulkDelete');
    Route::resource('/settings', SettingsController::class)->except(['show']);
    Route::resource('/qualitys', QualitysController::class)->parameters(['qualitys' => 'qualitys'])->except(['show']);
    Route::delete('/qualitys/bulk-delete', [QualitysController::class, 'bulkDelete'])->name('qualitys.bulkDelete');
});


///lang
Route::get('/switch-language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
