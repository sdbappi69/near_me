<?php

Route::group(['module' => 'Menu', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Menu\Controllers'], function() {

    Route::resource('Menu', 'MenuController');

});
