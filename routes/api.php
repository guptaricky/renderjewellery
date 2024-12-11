<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([

    // 'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    
});
    Route::middleware(['auth:api'])->group(function(){
        Route::post('refresh', [AuthController::class,'refresh']);
        Route::post('me', [AuthController::class,'me']);
        Route::post('logout', [AuthController::class,'logout']);
        Route::post('products/create', [ProductController::class, 'createProduct']);

        //cart
        Route::post('/cart/add', [CartController::class, 'addToCart']);
        Route::get('/cart', [CartController::class, 'viewCart']);

        //orders
        Route::post('/orders/create', [OrderController::class, 'createOrder']);
        Route::post('/orders/verify', [OrderController::class, 'verifyPayment']);

});
