<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/admin', [Dashboard::class, 'adminDashboard'])->middleware(['auth', 'verified'])->name('dashboard.admin');
Route::get('/dashboard/user', [Dashboard::class, 'userDashboard'])->middleware(['auth', 'verified'])->name('dashboard.user');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profileView', [ProfileController::class, 'index'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('users/{user}/edit-role', [RoleController::class, 'edit'])->middleware('role:admin')->name('users.edit-role');
// Route::post('users/{user}/update-role', [RoleController::class, 'update'])->middleware('role:admin')->name('users.update-role');

Route::middleware(['auth', 'role:SuperAdmin,Admin'])->group(function () {
    // Route::get('/admin/users', [RoleController::class, 'index'])->name('admin.users.index');
    // Route::post('/admin/users/{user}/update-role', [RoleController::class, 'update'])->name('admin.users.update-role');

    Route::get('/plan', [PlanController::class, 'create'])->name('plan.create');
    Route::post('/plan', [PlanController::class, 'store'])->name('plan.store');
    Route::patch('/plan', [PlanController::class, 'updateActive'])->name('plan.update');

    // Product Categories
    Route::get('/product-categories', [ProductCategoryController::class, 'create'])->name('productCategories.create');
    Route::post('/product-categories', [ProductCategoryController::class, 'store'])->name('productCategories.store');
    Route::patch('/product-categories/{id}/active', [ProductCategoryController::class, 'updateActive'])->name('productCategories.updateActive');
    Route::delete('/product-categories/{id}', [ProductCategoryController::class, 'destroy'])->name('productCategories.destroy');

    // Product Subcategories
    Route::get('/product-subcategories', [ProductSubCategoryController::class, 'create'])->name('productSubCategories.create');
    Route::post('/product-subcategories', [ProductSubCategoryController::class, 'store'])->name('productSubCategories.store');
    Route::patch('/product-subcategories/{id}/active', [ProductSubCategoryController::class, 'updateActive'])->name('productSubCategories.updateActive');
    Route::delete('/product-subcategories/{id}', [ProductSubCategoryController::class, 'destroy'])->name('productSubCategories.destroy');

    // Product Categories
    Route::get('/product-categories/{id}/edit', [ProductCategoryController::class, 'edit'])->name('productCategories.edit');
    Route::patch('/product-categories/{id}', [ProductCategoryController::class, 'update'])->name('productCategories.update');

    // Product Subcategories
    Route::get('/product-subcategories/{id}/edit', [ProductSubCategoryController::class, 'edit'])->name('productSubCategories.edit');
    Route::patch('/product-subcategories/{id}', [ProductSubCategoryController::class, 'update'])->name('productSubCategories.update');


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

Route::get('/products/create', [ProductController::class, 'showCreateForm'])->name('products.create');
Route::post('/products/create', [ProductController::class, 'createProduct'])->name('products.create');
Route::get('/products/detail/{id}', [ProductController::class, 'detailProduct'])->name('products.detail');



// Get csrf token from this 
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});


require __DIR__ . '/auth.php';
