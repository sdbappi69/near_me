<?php

Route::group(['module' => 'Slider', 'middleware' => ['api'], 'namespace' => 'App\Modules\Slider\Controllers'], function() {

    Route::resource('Slider', 'SliderController');

});
