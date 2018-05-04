<?php

Route::group(['module' => 'Photo', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Photo\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('photos', 'PhotoController');

    Route::get('photos/{id}/up', 'PhotoController@up');

    Route::get('photos/{id}/down', 'PhotoController@down');

});

Route::group(['module' => 'Photo', 'middleware' => ['web'], 'namespace' => 'App\Modules\Photo\Controllers'], function() {

    Route::get('photos', 'PhotoController@view');

    Route::get('photos/{id}', 'PhotoController@show');

});
