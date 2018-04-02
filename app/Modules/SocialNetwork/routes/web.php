<?php

Route::group(['module' => 'SocialNetwork', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\SocialNetwork\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('socials', 'SocialNetworkController');

});
