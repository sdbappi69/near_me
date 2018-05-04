<?php

Route::group(['module' => 'Testimonial', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Testimonial\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('testimonials', 'TestimonialController');

    Route::get('testimonials/{id}/up', 'TestimonialController@up');

    Route::get('testimonials/{id}/down', 'TestimonialController@down');

});

Route::group(['module' => 'Testimonial', 'middleware' => ['web'], 'namespace' => 'App\Modules\Testimonial\Controllers'], function() {

    Route::get('testimonials', 'TestimonialController@view');

    Route::get('testimonials/{id}', 'TestimonialController@show');

});
