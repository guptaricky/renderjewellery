<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OrderController;
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
        Route::post('upload/design', [ImageUploadController::class, 'uploadDesign']);

        //orders
        Route::post('/orders', [OrderController::class, 'createOrder']);
});
