<?php

Route::group(['module' => 'Type', 'middleware' => ['api'], 'namespace' => 'App\Modules\Type\Controllers'], function() {

    Route::resource('Type', 'TypeController');

});
