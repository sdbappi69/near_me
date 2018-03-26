<?php

Route::group(['module' => 'Role', 'middleware' => ['api'], 'namespace' => 'App\Modules\Role\Controllers'], function() {

    Route::resource('Role', 'RoleController');

});
