<?php

Route::group(['module' => 'PrintSale', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\PrintSale\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('print-sales', 'PrintSaleController');

    Route::get('print-sales/{id}/up', 'PrintSaleController@up');

    Route::get('print-sales/{id}/down', 'PrintSaleController@down');

    Route::resource('order-print-sales', 'OrderPrintSaleController');

});

Route::group(['module' => 'PrintSale', 'middleware' => ['web'], 'namespace' => 'App\Modules\PrintSale\Controllers'], function() {

    Route::get('print-sales', 'PrintSaleController@view');

    Route::get('print-sales/{id}', 'PrintSaleController@show');

    Route::post('order-print-sales', 'OrderPrintSaleController@store');

});
