<?php

Route::group(['module' => 'Setting', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Setting\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('settings', 'SettingController');

});
