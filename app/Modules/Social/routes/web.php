<?php

Route::group(['module' => 'Social', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Social\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('socials', 'SocialController');

    Route::get('socials/{id}/up', 'SocialController@up');

    Route::get('socials/{id}/down', 'SocialController@down');

});
