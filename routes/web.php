<?php

use App\Services\SendSMSService;
use Illuminate\Routing\RouteGroup;
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
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index_page')->middleware('getFestival');
Route::get('/coming-soon', [App\Http\Controllers\IndexController::class, 'showComingSoon'])->name('coming_soon_page');
Route::post('/store-perticipant', [App\Http\Controllers\IndexController::class, 'storePerticipant'])->name('store.perticipant');
Route::get('/store/{store_id}', [App\Http\Controllers\IndexController::class, 'storeData'])->name('store_page')->middleware('getFestival');
Route::get('/category/{category_id}', [App\Http\Controllers\IndexController::class, 'categoryData'])->name('category_page')->middleware('getFestival');
Route::get('/products', [App\Http\Controllers\IndexController::class, 'products'])->name('products_page')->middleware('getFestival');
Route::get('/cart', [App\Http\Controllers\IndexController::class, 'cartView'])->name('cart_view_page');
Route::get('/checkout', [App\Http\Controllers\IndexController::class, 'checkout'])->name('checkout_page');
Route::get('/quick-view/{id}', [App\Http\Controllers\IndexController::class, 'quickView'])->name('quick_view');
Route::get('/product/{slug}', [App\Http\Controllers\IndexController::class, 'detail'])->name('detail_page');
Route::middleware(['auth', 'getFestival'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\IndexController::class, 'dashboard'])->name('home');
    Route::post('/place_order', [App\Http\Controllers\IndexController::class, 'placeOrder'])->name('place_order');
    Route::get('/order-completed/{id}', [App\Http\Controllers\IndexController::class, 'orderCompleted'])->name('order_completed');
    Route::get('/orders', [App\Http\Controllers\IndexController::class, 'orders'])->name('orders_page');
    Route::get('/order/{order_id}', [App\Http\Controllers\IndexController::class, 'orderDetail'])->name('order_detail_page');
    Route::get('/profile', [App\Http\Controllers\IndexController::class, 'profile'])->name('profile_page');
    Route::put('/profile', [App\Http\Controllers\IndexController::class, 'profileUpdate'])->name('profile_update_page');
});
Route::post('submit-otp',  [App\Http\Controllers\Auth\LoginController::class, 'submitOtp'])->name('submit.otp');
Route::post('request-otp',  [App\Http\Controllers\Auth\LoginController::class, 'otpRequest'])->name('otp.login');
Auth::routes(['register' => false, 'reset' => false]);



