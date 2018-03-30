<?php

Route::group(['module' => 'Sale', 'middleware' => ['web'], 'namespace' => 'App\Modules\Sale\Controllers'], function() {

    Route::resource('Sale', 'SaleController');

});
