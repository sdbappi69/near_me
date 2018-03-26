<?php

Route::group(['module' => 'User', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\User\Controllers'], function() {

    Route::resource('users', 'UserController');

    Route::resource('password', 'PasswordController');

    Route::resource('profile', 'ProfileController');

    Route::resource('profile-password', 'ProfilePasswordController');

});
