<?php

Route::group(['module' => 'Theme', 'middleware' => ['api'], 'namespace' => 'App\Modules\Theme\Controllers'], function() {

    Route::resource('Theme', 'ThemeController');

});
