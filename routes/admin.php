<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Auth routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    // Authentication Routes...
    Auth::routes(['register' => false, 'reset' => false]);
    
    Route::group(['middleware' => 'auth:admin'], function() {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('attach-to-festival', [App\Http\Controllers\Admin\StoreController::class, 'attachToFestival'])->name('attach.festival.store.data');
        Route::get('sync-store-data', [App\Http\Controllers\Admin\StoreController::class, 'syncStoreData'])->name('sync.store.data');
        Route::resource('stores', StoreController::class)->only('index', 'destroy');
        Route::resource('festivals', FestivalController::class);
        Route::resource('categories', CategoryController::class);
    });
});

