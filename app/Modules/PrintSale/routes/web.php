<?php

Route::group(['module' => 'PrintSale', 'middleware' => ['web'], 'namespace' => 'App\Modules\PrintSale\Controllers'], function() {

    Route::resource('PrintSale', 'PrintSaleController');

});
