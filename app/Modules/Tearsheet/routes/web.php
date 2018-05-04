<?php

Route::group(['module' => 'Tearsheet', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Tearsheet\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('tearsheets', 'TearsheetController');

    Route::get('tearsheets/{id}/up', 'TearsheetController@up');

    Route::get('tearsheets/{id}/down', 'TearsheetController@down');

    Route::resource('order-tearsheets', 'OrderTearsheetController');

});

Route::group(['module' => 'Tearsheet', 'middleware' => ['web'], 'namespace' => 'App\Modules\Tearsheet\Controllers'], function() {

    Route::get('tearsheets', 'TearsheetController@view');

    Route::get('tearsheets/{id}', 'TearsheetController@show');

    Route::post('order-tearsheets', 'OrderTearsheetController@store');

});
