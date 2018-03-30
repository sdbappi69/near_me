<?php

Route::group(['module' => 'Biography', 'middleware' => ['api'], 'namespace' => 'App\Modules\Biography\Controllers'], function() {

    Route::resource('Biography', 'BiographyController');

});
