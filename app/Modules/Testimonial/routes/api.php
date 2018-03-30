<?php

Route::group(['module' => 'Testimonial', 'middleware' => ['api'], 'namespace' => 'App\Modules\Testimonial\Controllers'], function() {

    Route::resource('Testimonial', 'TestimonialController');

});
