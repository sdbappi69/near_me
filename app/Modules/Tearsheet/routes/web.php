<?php

Route::group(['module' => 'Tearsheet', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Tearsheet\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('tearsheets', 'TearsheetController');

    Route::get('tearsheets/{id}/up', 'TearsheetController@up');

    Route::get('tearsheets/{id}/down', 'TearsheetController@down');

});
