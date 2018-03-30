<?php

Route::group(['module' => 'Category', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Category\Controllers'], function() {

    Route::resource('categories', 'CategoryController');

    Route::get('categories/{id}/up', 'CategoryController@up');

    Route::get('categories/{id}/down', 'CategoryController@down');

    Route::get('categories/{photo_id}/{category_id}/photo-up', 'CategoryController@photo_up');

    Route::get('categories/{photo_id}/{category_id}/photo-down', 'CategoryController@photo_down');

    Route::post('categories/photos', 'CategoryController@photos');

});
