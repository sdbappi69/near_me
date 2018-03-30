<?php

Route::group(['module' => 'Size', 'middleware' => ['api'], 'namespace' => 'App\Modules\Size\Controllers'], function() {

    Route::resource('Size', 'SizeController');

});
