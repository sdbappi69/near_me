<?php

Route::group(['module' => 'Home', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Home\Controllers', 'prefix' => 'panel'], function() {

    Route::get('/home', 'HomeController@index');

});

Route::group(['module' => 'Home', 'middleware' => ['web'], 'namespace' => 'App\Modules\Home\Controllers'], function() {

    Route::get('/home', 'HomeController@view');

});