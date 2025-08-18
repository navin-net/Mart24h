<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;

Route::prefix('pos')->name('pos.')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('index');
    Route::get('/search', [PosController::class, 'search'])->name('search');
    Route::get('/filter', [PosController::class, 'filter'])->name('filter');
    Route::post('/process-payment', [PosController::class, 'processPayment'])->name('process-payment');
    Route::get('/customer-display', [PosController::class, 'customerDisplay'])->name('customer-display');
});
