<?php

Route::group(['module' => 'History', 'middleware' => ['web'], 'namespace' => 'App\Modules\History\Controllers'], function() {

    Route::resource('History', 'HistoryController');

});
