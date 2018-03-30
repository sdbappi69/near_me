<?php

Route::group(['module' => 'PrintSale', 'middleware' => ['api'], 'namespace' => 'App\Modules\PrintSale\Controllers'], function() {

    Route::resource('PrintSale', 'PrintSaleController');

});
