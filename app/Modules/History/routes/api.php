<?php

Route::group(['module' => 'History', 'middleware' => ['api'], 'namespace' => 'App\Modules\History\Controllers'], function() {

    Route::resource('History', 'HistoryController');

});
