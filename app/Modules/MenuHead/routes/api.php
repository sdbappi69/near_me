<?php

Route::group(['module' => 'MenuHead', 'middleware' => ['api'], 'namespace' => 'App\Modules\MenuHead\Controllers'], function() {

    Route::resource('MenuHead', 'MenuHeadController');

});
