<?php

Route::group(['module' => 'Home', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Home\Controllers', 'prefix' => 'panel'], function() {

    Route::get('/home', 'HomeController@index');

    Route::post('/update-location', 'HomeController@update_location');

});

Route::group(['module' => 'Home', 'middleware' => ['web'], 'namespace' => 'App\Modules\Home\Controllers'], function() {

    Route::get('/home', 'HomeController@view');

});