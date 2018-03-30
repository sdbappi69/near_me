<?php

Route::group(['module' => 'Award', 'middleware' => ['api'], 'namespace' => 'App\Modules\Award\Controllers'], function() {

    Route::resource('Award', 'AwardController');

});
