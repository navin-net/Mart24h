<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;

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

// Route::get('/main', function () {
//     return view('dashboard.main');
// });


Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');


// Route::post('/login', [AuthController::class, 'login'])
//     ->middleware('throttle:3,1') // 3 attempts in 3 minutes
//     ->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::middleware('auth')->get('/product', [ProductController::class, 'index'])->name('index');




///lang
// Route::post('language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/switch-language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
