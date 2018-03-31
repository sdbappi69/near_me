<?php

Route::group(['module' => 'Sale', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Sale\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('sales', 'SaleController');

    Route::get('sales/{id}/up', 'SaleController@up');

    Route::get('sales/{id}/down', 'SaleController@down');

});
