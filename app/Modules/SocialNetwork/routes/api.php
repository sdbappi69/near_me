<?php

Route::group(['module' => 'SocialNetwork', 'middleware' => ['api'], 'namespace' => 'App\Modules\SocialNetwork\Controllers'], function() {

    Route::resource('SocialNetwork', 'SocialNetworkController');

});
