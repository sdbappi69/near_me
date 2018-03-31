<?php

Route::group(['module' => 'Award', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Award\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('awards', 'AwardController');

    Route::get('awards/{id}/up', 'AwardController@up');

    Route::get('awards/{id}/down', 'AwardController@down');

});
