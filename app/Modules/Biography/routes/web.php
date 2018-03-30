<?php

Route::group(['module' => 'Biography', 'middleware' => ['web'], 'namespace' => 'App\Modules\Biography\Controllers'], function() {

    Route::resource('Biography', 'BiographyController');

});
