<?php

Route::group(['module' => 'Theme', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Theme\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('themes', 'ThemeController');

});
