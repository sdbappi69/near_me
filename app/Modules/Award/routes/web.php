<?php

Route::group(['module' => 'Award', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Award\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('awards', 'AwardController');

    Route::get('awards/{id}/up', 'AwardController@up');

    Route::get('awards/{id}/down', 'AwardController@down');

});

Route::group(['module' => 'Award', 'middleware' => ['web'], 'namespace' => 'App\Modules\Award\Controllers'], function() {

    Route::get('awards', 'AwardController@view');

    Route::get('awards/{id}', 'AwardController@show');

});
