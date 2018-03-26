<?php

Route::group(['module' => 'Permission', 'middleware' => ['api'], 'namespace' => 'App\Modules\Permission\Controllers'], function() {

    Route::resource('Permission', 'PermissionController');

});
