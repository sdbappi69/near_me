<?php

Route::group(['module' => 'Tearsheet', 'middleware' => ['web'], 'namespace' => 'App\Modules\Tearsheet\Controllers'], function() {

    Route::resource('Tearsheet', 'TearsheetController');

});
