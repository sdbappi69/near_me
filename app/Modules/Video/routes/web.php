<?php

Route::group(['module' => 'Video', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Video\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('videos', 'VideoController');

    Route::get('videos/{id}/up', 'VideoController@up');

    Route::get('videos/{id}/down', 'VideoController@down');

});

Route::group(['module' => 'Video', 'middleware' => ['web'], 'namespace' => 'App\Modules\Video\Controllers'], function() {

    Route::get('videos', 'VideoController@view');

    Route::get('videos/{id}', 'VideoController@show');

});
