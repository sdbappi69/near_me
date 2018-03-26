<?php

Route::group(['module' => 'MenuHead', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\MenuHead\Controllers'], function() {

    Route::resource('MenuHead', 'MenuHeadController');

});
