<?php

Route::group(['module' => 'Setting', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Setting\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('settings', 'SettingController');

});

Route::group(['module' => 'Setting', 'middleware' => ['web'], 'namespace' => 'App\Modules\Setting\Controllers'], function() {

    Route::get('contacts', 'SettingController@show');

});