<?php

Route::group(['module' => 'History', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\History\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('history', 'HistoryController');

});
