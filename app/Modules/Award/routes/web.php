<?php

Route::group(['module' => 'Award', 'middleware' => ['web'], 'namespace' => 'App\Modules\Award\Controllers'], function() {

    Route::resource('Award', 'AwardController');

});
