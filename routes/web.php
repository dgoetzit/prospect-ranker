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

// Route::get('/', function () {
//     return view('welcomed');
// });

Route::get('/', 'PlayerController@index');
Route::get('/test', 'PlayerController@indexTest');
// Route::get('/past', 'PlayerController@indexPast'); 

// Route::get('/players/create', 'PlayerController@create');
// Route::get('/players/create/a', 'PlayerController@createA');
// Route::get('/players/create/aplus', 'PlayerController@createHighA');
// Route::get('/players/create/aa', 'PlayerController@createAA');
// Route::get('/players/create/aaa', 'PlayerController@createAAA');
