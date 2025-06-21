<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

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

// Redirect root to catalog
Route::get('/', function () {
    return redirect()->route('catalog.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public catalog routes
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/product/{product}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog/category/{category}', [CatalogController::class, 'category'])->name('catalog.category');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Product management (for producers)
    Route::resource('products', ProductController::class);

    // Category management (for admins/producers)
    Route::resource('categories', CategoryController::class);

    // Order management (for buyers)
    Route::resource('orders', OrderController::class)->except(['edit', 'update', 'destroy']);
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
