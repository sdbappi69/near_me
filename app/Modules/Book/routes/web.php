<?php

Route::group(['module' => 'Book', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Book\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('books', 'BookController');

    Route::get('books/{id}/up', 'BookController@up');

    Route::get('books/{id}/down', 'BookController@down');

});

Route::group(['module' => 'Book', 'middleware' => ['web'], 'namespace' => 'App\Modules\Book\Controllers'], function() {

    Route::get('books', 'BookController@view');

    Route::get('books/{id}', 'BookController@show');

});
