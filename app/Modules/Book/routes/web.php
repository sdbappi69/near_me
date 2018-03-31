<?php

Route::group(['module' => 'Book', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Book\Controllers', 'prefix' => 'panel'], function() {

    Route::resource('books', 'BookController');

    Route::get('books/{id}/up', 'BookController@up');

    Route::get('books/{id}/down', 'BookController@down');

});
