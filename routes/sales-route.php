<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('home');
});
Route::group(['middleware' => ['sales']], function () {

Route::get('/dashboard', 'Sales\SalesController@index')->name('sales-dashboard');

    Route::prefix('profile')->name('profile')->group(function () {
        Route::get('/change-password','Sales\ProfileController@ChangePasswordView')->name('.change-password');
        Route::post('/change-password','Sales\ProfileController@ChangePasswordSave');
    });
    Route::prefix('category')->name('category')->group(function () {
        Route::get('/list','Sales\CategoryController@index')->name('.view');
    });
    Route::prefix('brand')->name('brand')->group(function () {
        Route::get('/list','Sales\BrandController@index')->name('.view');
    });

    Route::prefix('product')->name('product')->group(function () {
        Route::get('/list','Sales\ProductController@index')->name('.view');
    });
    Route::prefix('customer')->name('customer')->group(function () {
        Route::get('/list','Sales\CustomerController@index')->name('.view');
    });
    Route::prefix('order')->name('order')->group(function () {
        Route::get('/list','Sales\OrderController@index')->name('.view');
        Route::any('/search','Sales\OrderController@search')->name('.search');
    });
    Route::prefix('all-stock')->name('all-stock')->group(function () {
        Route::get('/list','Sales\StockController@AllStock')->name('.view');
        Route::any('/search','Sales\StockController@searchAllStock')->name('.search');
        Route::get('/details/{id}','Sales\StockController@AllStockDetails')->name('.details');
    });
});
