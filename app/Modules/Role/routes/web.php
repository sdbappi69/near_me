<?php

Route::group(['module' => 'Role', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Role\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('roles', 'RoleController');

    Route::get('roles/{id}/up', 'RoleController@up');

    Route::get('roles/{id}/down', 'RoleController@down');

});
