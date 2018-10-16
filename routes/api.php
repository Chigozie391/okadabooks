<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/books'], function () {
Route::get('', 'BookController@index');
Route::get('/{id}', 'BookController@show')->name('books.show');
Route::post('/{id}', 'BookController@update');
Route::post('', 'BookController@store');
Route::delete('/{id}', 'BookController@destroy');
});

Route::get('/author/{id}', 'BookController@showAuthorBooks')->name('author.show');
