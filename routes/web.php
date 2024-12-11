<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Models\Cart;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profileView', [ProfileController::class, 'index'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:SuperAdmin,Admin'])->group(function () {

    //dashboard
    Route::get('/dashboard/admin', [Dashboard::class, 'adminDashboard'])->middleware(['auth', 'verified'])->name('dashboard.admin');

    //plan
    Route::get('/plan', [PlanController::class, 'create'])->name('plan.create');
    Route::post('/plan', [PlanController::class, 'store'])->name('plan.store');
    Route::patch('/plan', [PlanController::class, 'updateActive'])->name('plan.update');

    // Product Categories
    Route::get('/product-categories', [ProductCategoryController::class, 'create'])->name('productCategories.create');
    Route::post('/product-categories', [ProductCategoryController::class, 'store'])->name('productCategories.store');
    Route::patch('/product-categories/{id}/active', [ProductCategoryController::class, 'updateActive'])->name('productCategories.updateActive');
    Route::delete('/product-categories/{id}', [ProductCategoryController::class, 'destroy'])->name('productCategories.destroy');
    Route::get('/product-categories/{id}/edit', [ProductCategoryController::class, 'edit'])->name('productCategories.edit');
    Route::patch('/product-categories/{id}', [ProductCategoryController::class, 'update'])->name('productCategories.update');

    // Product Subcategories
    Route::get('/product-subcategories', [ProductSubCategoryController::class, 'create'])->name('productSubCategories.create');
    Route::post('/product-subcategories', [ProductSubCategoryController::class, 'store'])->name('productSubCategories.store');
    Route::patch('/product-subcategories/{id}/active', [ProductSubCategoryController::class, 'updateActive'])->name('productSubCategories.updateActive');
    Route::delete('/product-subcategories/{id}', [ProductSubCategoryController::class, 'destroy'])->name('productSubCategories.destroy');
    Route::get('/product-subcategories/{id}/edit', [ProductSubCategoryController::class, 'edit'])->name('productSubCategories.edit');
    Route::patch('/product-subcategories/{id}', [ProductSubCategoryController::class, 'update'])->name('productSubCategories.update');

    //products
    Route::post('/products/storeComment', [ProductController::class, 'storeComment'])->name('products.storeComment');
    Route::get('/products/approval', [ProductController::class, 'approval'])->name('products.approval');
    Route::get('/products/detail/{id}', [ProductController::class, 'detailProduct'])->name('products.detail');

    Route::get('/user/list', [UserController::class, 'userList'])->name('user.list');
    Route::get('/user', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::patch('/user', [UserController::class, 'updateActive'])->name('user.update');
    Route::get('/user/details/{id}', [UserController::class, 'userDetails'])->where('id', '[0-9]+')->name('user.details');
    Route::get('/user/designDetails/{id}/{upload_id}', [UserController::class, 'designDetails'])->where('id', '[0-9]+')->name('user.designDetails');
    Route::get('/orders/orderList', [OrderController::class, 'orderList'])->name('orders.orderList');
    Route::get('/products/productList', [ProductController::class, 'productList'])->name('products.productList');
    Route::get('/users/search', [UserController::class, 'search'])->name('user.search');

});

Route::middleware(['auth', 'role:Designer,Customer'])->group(function () {

    //dashboard
    Route::get('/dashboard/user', [Dashboard::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('dashboard.user');

    //cart
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');

    //orders
    Route::post('/orders/create', [OrderController::class, 'createOrder']);
    Route::post('/orders/verify', [OrderController::class, 'verifyPayment']);

    Route::get('/products/create', [ProductController::class, 'showCreateForm'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'createProduct'])->name('products.create');
    Route::get('/products/eCommerce/{id}', [ProductController::class, 'eCommerce'])->name('products.eCommerce');

});

// Get csrf token from this 
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});


require __DIR__ . '/auth.php';
