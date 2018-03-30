<?php

Route::group(['module' => 'Setting', 'middleware' => ['web'], 'namespace' => 'App\Modules\Setting\Controllers'], function() {

    Route::resource('Setting', 'SettingController');

});
