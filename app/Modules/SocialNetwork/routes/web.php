<?php

Route::group(['module' => 'SocialNetwork', 'middleware' => ['web'], 'namespace' => 'App\Modules\SocialNetwork\Controllers'], function() {

    Route::resource('SocialNetwork', 'SocialNetworkController');

});
