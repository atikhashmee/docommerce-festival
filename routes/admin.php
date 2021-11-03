<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Auth routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Authentication Routes...
    Auth::routes(['register' => false, 'reset' => false]);
    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('/set-festival', [App\Http\Controllers\Admin\DashboardController::class, 'postFestival'])->name('dashboard.postFestival');
        Route::get('/set-festival', [App\Http\Controllers\Admin\DashboardController::class, 'setFestival'])->name('dashboard.setFestival');
        Route::resource('users', UserController::class);
        Route::resource('festivals', FestivalController::class);
        Route::post('orders-status-change', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderChange'])->name('order.update.change');
        Route::post('orders-status-update', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderStatus'])->name('order.update.status');
        Route::get('orders/{order_id}', [App\Http\Controllers\Admin\OrderController::class, 'changeStatus'])->name('order.change.status');
        Route::resource('orders', OrderController::class);
        Route::middleware(['configFestival', 'getFestival'])->group(function () {
            Route::get('sync-store-data', [App\Http\Controllers\Admin\StoreController::class, 'syncStoreData'])->name('sync.store.data');
            Route::resource('stores', StoreController::class)->only('index', 'destroy');
            Route::resource('categories', CategoryController::class);
            Route::get('products/get-store-products/{store_id}', [App\Http\Controllers\Admin\ProductController::class, 'storeProduct'])->name('product.get.store.products');
            Route::post('products/import', [App\Http\Controllers\Admin\ProductController::class, 'importStore'])->name('product.import.store');
            Route::get('products/import', [App\Http\Controllers\Admin\ProductController::class, 'import'])->name('product.import');
            Route::post('products/delete-all', [App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('products.deteletAll');
            Route::resource('products', ProductController::class)->only('index', 'destroy');
        });
    });
});

