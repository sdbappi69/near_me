<?php

Route::group(['module' => 'Sale', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Sale\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('sales', 'SaleController');

    Route::get('sales/{id}/up', 'SaleController@up');

    Route::get('sales/{id}/down', 'SaleController@down');

    Route::resource('order-sales', 'OrderSaleController');

});

Route::group(['module' => 'Sale', 'middleware' => ['web'], 'namespace' => 'App\Modules\Sale\Controllers'], function() {

    Route::get('sales', 'SaleController@view');

    Route::get('sales/{id}', 'SaleController@show');

    Route::post('order-sales', 'OrderSaleController@store');

});
