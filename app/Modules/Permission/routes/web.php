<?php

Route::group(['module' => 'Permission', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Permission\Controllers'], function() {

    Route::resource('permissions', 'PermissionController');

});
