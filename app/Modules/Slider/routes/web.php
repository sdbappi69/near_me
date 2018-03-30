<?php

Route::group(['module' => 'Slider', 'middleware' => ['web'], 'namespace' => 'App\Modules\Slider\Controllers'], function() {

    Route::resource('Slider', 'SliderController');

});
