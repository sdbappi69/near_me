<?php

Route::group(['module' => 'Photo', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Photo\Controllers'], function() {

    Route::resource('photos', 'PhotoController');

    Route::get('photos/{id}/up', 'PhotoController@up');

    Route::get('photos/{id}/down', 'PhotoController@down');

});
