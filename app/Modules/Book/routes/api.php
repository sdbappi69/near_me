<?php

Route::group(['module' => 'Book', 'middleware' => ['api'], 'namespace' => 'App\Modules\Book\Controllers'], function() {

    Route::resource('Book', 'BookController');

});
