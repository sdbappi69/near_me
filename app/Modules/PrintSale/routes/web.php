<?php

Route::group(['module' => 'PrintSale', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\PrintSale\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('print-sales', 'PrintSaleController');

    Route::get('print-sales/{id}/up', 'PrintSaleController@up');

    Route::get('print-sales/{id}/down', 'PrintSaleController@down');

});
