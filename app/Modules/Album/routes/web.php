<?php

Route::group(['module' => 'Album', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Album\Controllers'], function() {

    Route::resource('albums', 'AlbumController');

    Route::get('albums/{id}/up', 'AlbumController@up');

    Route::get('albums/{id}/down', 'AlbumController@down');

});
