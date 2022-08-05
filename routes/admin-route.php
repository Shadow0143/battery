<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('home');
});
Route::group(['middleware' => ['admin']], function () {

Route::get('/dashboard', 'Admin\AdminController@index')->name('admin-dashboard');
      Route::prefix('profile')->name('profile')->group(function () {
          Route::get('/change-password','Admin\ProfileController@ChangePasswordView')->name('.change-password');
          Route::post('/change-password','Admin\ProfileController@ChangePasswordSave');
      });
    Route::prefix('category')->name('category')->group(function () {
        Route::get('/list','Admin\CategoryController@index')->name('.view');
        Route::get('/add','Admin\CategoryController@add')->name('.add');
        Route::post('/add','Admin\CategoryController@save');
        Route::get('/edit/{id}','Admin\CategoryController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\CategoryController@update');
        Route::get('/delete/{id}', 'Admin\CategoryController@delete')->name('.delete');
    });

    Route::prefix('brand')->name('brand')->group(function () {
        Route::get('/list','Admin\BrandController@index')->name('.view');
        Route::get('/add','Admin\BrandController@add')->name('.add');
        Route::post('/add','Admin\BrandController@save');
        Route::get('/edit/{id}','Admin\BrandController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\BrandController@update');
        Route::get('/delete/{id}', 'Admin\BrandController@delete')->name('.delete');
    });

    Route::prefix('product')->name('product')->group(function () {
        Route::get('/list','Admin\ProductController@index')->name('.view');
        Route::get('/add','Admin\ProductController@add')->name('.add');
         Route::get('/serachbarcode','Admin\ProductController@serachbarcode')->name('.serachbarcode');
        Route::post('/add','Admin\ProductController@save');
        Route::get('/edit/{id}','Admin\ProductController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\ProductController@update');
        Route::get('/delete/{id}', 'Admin\ProductController@delete')->name('.delete');
        Route::get('/print','Admin\ProductController@print')->name('.print');
        Route::get('/csv','Admin\ProductController@csvDownload')->name('.csv');
    });
    Route::prefix('stock')->name('stock')->group(function () {
        Route::get('/list','Admin\StockController@index')->name('.view');
        Route::get('/add','Admin\StockController@add')->name('.add');
        Route::post('/add','Admin\StockController@save');
        Route::get('/edit/{id}','Admin\StockController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\StockController@update');
        Route::get('/delete/{id}', 'Admin\StockController@delete')->name('.delete');
    });
    Route::prefix('edit-stock')->name('edit-stock')->group(function () {
        Route::get('/add/{id}','Admin\EditstockController@add')->name('.add');
        Route::post('/add/{id}','Admin\EditstockController@save');
        Route::get('/edit/{id}','Admin\EditstockController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\EditstockController@update');
        Route::get('/delete/{id}', 'Admin\EditstockController@delete')->name('.delete');
    });

    Route::prefix('all-stock')->name('all-stock')->group(function () {
        Route::any('/search','Admin\StockController@searchAllStock')->name('.search');
        Route::get('/list','Admin\StockController@AllStock')->name('.view');
        Route::get('/inout','Admin\StockController@AllStockView')->name('.allview');
        Route::get('/search-by-date-inout','Admin\StockController@searchBYDate')->name('.searchBYDate');
        Route::get('/details/{id}','Admin\StockController@AllStockDetails')->name('.details');
        Route::post('/inout_print','Admin\StockController@AllStockViewPrint')->name('.inout_print');
    });
    Route::prefix('customer')->name('customer')->group(function () {
        Route::get('/list','Admin\CustomerController@index')->name('.view');
        Route::get('/add','Admin\CustomerController@add')->name('.add');
        Route::post('/add','Admin\CustomerController@save');
        Route::get('/edit/{id}','Admin\CustomerController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\CustomerController@update');
        Route::get('/delete/{id}', 'Admin\CustomerController@delete')->name('.delete');
    });
    Route::prefix('order')->name('order')->group(function () {
        Route::get('/list','Admin\OrderController@index')->name('.view');
        Route::any('/search','Admin\OrderController@search')->name('.search');
        Route::get('/add','Admin\OrderController@add')->name('.add');
        Route::post('/add','Admin\OrderController@save');
        Route::get('/edit/{id}','Admin\OrderController@edit')->name('.edit');

        Route::get('/reprint/{id}','Admin\OrderController@reprint')->name('.reprint');
        
        Route::post('/edit/{id}','Admin\OrderController@update');
        Route::get('/delete/{id}', 'Admin\OrderController@delete')->name('.delete');
    });
    Route::prefix('order-details')->name('order-details')->group(function () {
        Route::get('/add/{id}','Admin\OrderdetailsController@add')->name('.add');
        Route::post('/add/{id}','Admin\OrderdetailsController@save');
        Route::get('/edit/{id}','Admin\OrderdetailsController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\OrderdetailsController@update');
        Route::get('/delete/{id}', 'Admin\OrderdetailsController@delete')->name('.delete');
    });
    Route::prefix('bar-code')->name('bar-code')->group(function () {
        Route::get('/add/{id}','Admin\BarcodeController@add')->name('.add');
        Route::post('/add/{id}','Admin\BarcodeController@save');
        Route::get('/edit/{id}','Admin\BarcodeController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\BarcodeController@update');
        Route::get('/delete/{id}', 'Admin\BarcodeController@delete')->name('.delete');
    });
    Route::prefix('user')->name('user')->group(function () {
        Route::get('/list','Admin\UserController@index')->name('.view');
        Route::get('/add','Admin\UserController@add')->name('.add');
        Route::post('/add','Admin\UserController@save');
        Route::get('/edit/{id}','Admin\UserController@edit')->name('.edit');
        Route::post('/edit/{id}','Admin\UserController@update');
        Route::get('/delete/{id}', 'Admin\UserController@delete')->name('.delete');
    });
  });
