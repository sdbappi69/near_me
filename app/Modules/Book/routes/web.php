<?php

Route::group(['module' => 'Book', 'middleware' => ['web'], 'namespace' => 'App\Modules\Book\Controllers'], function() {

    Route::resource('Book', 'BookController');

});
