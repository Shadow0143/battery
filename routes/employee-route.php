<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('home');
});
Route::group(['middleware' => ['employee']], function () {

Route::get('/dashboard', 'Employee\EmployeeController@index')->name('employee-dashboard');
    Route::prefix('profile')->name('profile')->group(function () {
        Route::get('/change-password','Employee\ProfileController@ChangePasswordView')->name('.change-password');
        Route::post('/change-password','Employee\ProfileController@ChangePasswordSave');
    });  
    Route::prefix('category')->name('category')->group(function () {
        Route::get('/list','Employee\CategoryController@index')->name('.view');
        Route::get('/add','Employee\CategoryController@add')->name('.add');
        Route::post('/add','Employee\CategoryController@save');
    });
    Route::prefix('brand')->name('brand')->group(function () {
        Route::get('/list','Employee\BrandController@index')->name('.view');
        Route::get('/add','Employee\BrandController@add')->name('.add');
        Route::post('/add','Employee\BrandController@save');
    });

    Route::prefix('product')->name('product')->group(function () {
        Route::get('/list','Employee\ProductController@index')->name('.view');
        Route::get('/add','Employee\ProductController@add')->name('.add');
        Route::get('/serachbarcode','Employee\ProductController@serachbarcode')->name('.serachbarcode');
        Route::post('/add','Employee\ProductController@save');
    });
    Route::prefix('customer')->name('customer')->group(function () {
        Route::get('/list','Employee\CustomerController@index')->name('.view');
        Route::get('/add','Employee\CustomerController@add')->name('.add');
        Route::post('/add','Employee\CustomerController@save');
    });
    Route::prefix('order')->name('order')->group(function () {
        Route::get('/list','Employee\OrderController@index')->name('.view');
        Route::any('/search','Employee\OrderController@search')->name('.search');
        Route::get('/add','Employee\OrderController@add')->name('.add');
        Route::post('/add','Employee\OrderController@save');
    });
    Route::prefix('stock')->name('stock')->group(function () {
        Route::get('/list','Employee\StockController@index')->name('.view');
        Route::get('/add','Employee\StockController@add')->name('.add');
        Route::post('/add','Employee\StockController@save');
    });
    Route::prefix('all-stock')->name('all-stock')->group(function () {
        Route::get('/list','Employee\StockController@AllStock')->name('.view');
        Route::any('/search','Employee\StockController@searchAllStock')->name('.search');
        Route::get('/details/{id}','Employee\StockController@AllStockDetails')->name('.details');
    });

});
