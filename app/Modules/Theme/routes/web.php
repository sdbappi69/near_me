<?php

Route::group(['module' => 'Theme', 'middleware' => ['web'], 'namespace' => 'App\Modules\Theme\Controllers'], function() {

    Route::resource('Theme', 'ThemeController');

});
