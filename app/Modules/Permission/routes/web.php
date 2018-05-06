<?php

Route::group(['module' => 'Permission', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Permission\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('permissions', 'PermissionController');

});
