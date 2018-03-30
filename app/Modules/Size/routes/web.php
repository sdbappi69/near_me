<?php

Route::group(['module' => 'Size', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Size\Controllers'], function() {

    Route::resource('sizes', 'SizeController');

});
