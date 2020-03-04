<?php

Route::group(['module' => 'Type', 'middleware' => ['web'], 'namespace' => 'App\Modules\Type\Controllers'], function() {

    Route::resource('Type', 'TypeController');

});
