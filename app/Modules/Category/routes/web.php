<?php

Route::group(['module' => 'Category', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Category\Controllers'], function() {

    Route::resource('categories', 'CategoryController');

    Route::get('categories/{id}/up', 'CategoryController@up');

    Route::get('categories/{id}/down', 'CategoryController@down');

});
