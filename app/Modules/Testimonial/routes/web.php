<?php

Route::group(['module' => 'Testimonial', 'middleware' => ['web'], 'namespace' => 'App\Modules\Testimonial\Controllers'], function() {

    Route::resource('Testimonial', 'TestimonialController');

});
