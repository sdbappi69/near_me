<?php

Route::group(['module' => 'Menu', 'middleware' => ['api'], 'namespace' => 'App\Modules\Menu\Controllers'], function() {

    Route::resource('Menu', 'MenuController');

});
