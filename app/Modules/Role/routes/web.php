<?php

Route::group(['module' => 'Role', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Role\Controllers'], function() {

    Route::resource('roles', 'RoleController');

});
