<?php

Route::group(['module' => 'Social', 'middleware' => ['api'], 'namespace' => 'App\Modules\Social\Controllers'], function() {

    Route::resource('Social', 'SocialController');

});
