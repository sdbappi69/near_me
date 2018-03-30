<?php

Route::group(['module' => 'Sale', 'middleware' => ['api'], 'namespace' => 'App\Modules\Sale\Controllers'], function() {

    Route::resource('Sale', 'SaleController');

});
