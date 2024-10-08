<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::namespace('Web')->group(function(){
    Route::get('/', 'HomeController@index')->name('/');
    
    Route::get('movie-desc/{id}', 'HomeController@show')->name('movie.show');
    Route::get('search', 'HomeController@search')->name('movie.search');
    // Route::get('/search-suggestions', 'HomeController@searchSuggestions')->name('movie.searchSuggestions');
});