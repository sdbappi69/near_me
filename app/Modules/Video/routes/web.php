<?php

Route::group(['module' => 'Video', 'middleware' => ['web'], 'namespace' => 'App\Modules\Video\Controllers'], function() {

    Route::resource('Video', 'VideoController');

});
