<?php

Route::group(['module' => 'Tearsheet', 'middleware' => ['api'], 'namespace' => 'App\Modules\Tearsheet\Controllers'], function() {

    Route::resource('Tearsheet', 'TearsheetController');

});
