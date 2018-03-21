<?php
/**
 * Misc. pages
 */
Route::get('/', 'PageController@welcome');
Route::get('/about', 'PageController@about');
Route::get('/contact', 'PageController@contact');

/**
 * Books
 */
Route::get('/books', 'BookController@index');
Route::get('/books/{title}', 'BookController@show');

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');