<?php

Route::group(['module' => 'Album', 'middleware' => ['api'], 'namespace' => 'App\Modules\Album\Controllers'], function() {

    Route::resource('Album', 'AlbumController');

});
