<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/panel', function () {
    return redirect('/login');
});

Route::get('/clear-all-cache',function(){
   
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('clear-compiled');
    
    return "All cache clear";
    
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

	Route::get('/panel/home', 'HomeController@index')->name('home');
	
});
