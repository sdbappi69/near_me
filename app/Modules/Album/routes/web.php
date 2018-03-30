<?php

Route::group(['module' => 'Album', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Album\Controllers'], function() {

    Route::resource('albums', 'AlbumController');

    Route::get('albums/{id}/up', 'AlbumController@up');

    Route::get('albums/{id}/down', 'AlbumController@down');

    Route::get('albums/{photo_id}/{album_id}/photo-up', 'AlbumController@photo_up');

    Route::get('albums/{photo_id}/{album_id}/photo-down', 'AlbumController@photo_down');

    Route::post('albums/photos', 'AlbumController@photos');

});
