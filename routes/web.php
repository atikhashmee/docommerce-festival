<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index_page');
Route::get('/store/{store_id}', [App\Http\Controllers\IndexController::class, 'storeData'])->name('store_page');
Route::get('/category/{category_id}', [App\Http\Controllers\IndexController::class, 'categoryData'])->name('category_page');
Route::get('/cart', [App\Http\Controllers\IndexController::class, 'cartView'])->name('cart_view_page');
Route::get('/checkout', [App\Http\Controllers\IndexController::class, 'checkout'])->name('checkout_page');
Route::post('/place_order', [App\Http\Controllers\IndexController::class, 'placeOrder'])->name('place_order');
Route::get('/order-completed/{id}', [App\Http\Controllers\IndexController::class, 'orderCompleted'])->name('order_completed');
Route::get('/orders', [App\Http\Controllers\IndexController::class, 'orders'])->name('orders_page');
Route::get('/profile', [App\Http\Controllers\IndexController::class, 'profile'])->name('profile_page');
Route::put('/profile', [App\Http\Controllers\IndexController::class, 'profileUpdate'])->name('profile_update_page');

Route::resource('stores', \App\Http\Controllers\StoreController::class);
Route::resource('festivals', \App\Http\Controllers\FestivalController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
