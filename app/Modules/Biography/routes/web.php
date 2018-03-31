<?php

Route::group(['module' => 'Biography', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Biography\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('biographies', 'BiographyController');
    
    Route::get('biographies/{id}/up', 'BiographyController@up');

    Route::get('biographies/{id}/down', 'BiographyController@down');

});
