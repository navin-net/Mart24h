<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'profile']); // manually protected
    Route::post('/profile/update', [AuthController::class, 'updateProfile']); // Update profile
    Route::post('/logout', [AuthController::class, 'logout']);   // manually protected
    Route::get('/groups',[AuthController::class,'getGroups']);
});





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/product-alerts', [AuthController::class, 'getAlerts']);
// Route::get('/groups', [AuthController::class,'getGroups']);
// Route::get('/groups/{id}', [AuthController::class, 'show']);