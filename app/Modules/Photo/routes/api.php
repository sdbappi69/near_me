<?php

Route::group(['module' => 'Photo', 'middleware' => ['api'], 'namespace' => 'App\Modules\Photo\Controllers'], function() {

    Route::resource('Photo', 'PhotoController');

});
