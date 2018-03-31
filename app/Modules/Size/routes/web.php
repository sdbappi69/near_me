<?php

Route::group(['module' => 'Size', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Size\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('sizes', 'SizeController');

});
