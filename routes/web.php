<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
// Test pages
Route::view('/empty_page', 'empty_page');
Route::view('/testing', 'testing');

// Authentication
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin', [AuthController::class, 'login'])
    ->middleware('throttle:3,1')
    ->name('admin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Language switch
Route::get('/switch-language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/product-alerts', [AuthController::class, 'getAlerts']);



// Load other route files
require __DIR__ . '/shop.php';
require __DIR__ . '/pos.php';
require __DIR__ . '/admin.php';
