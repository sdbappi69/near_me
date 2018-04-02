<?php

Route::group(['module' => 'Slider', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Slider\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('sliders', 'SliderController');

    Route::get('sliders/{id}/up', 'SliderController@up');

    Route::get('sliders/{id}/down', 'SliderController@down');

});
