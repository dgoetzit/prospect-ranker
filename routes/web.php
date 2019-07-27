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

Route::get('/test', function () {
    return view('test');
});

Route::get('/', 'HomeController@home');
// Route::get('/test', 'PlayerController@indexTest');
// Route::get('/past', 'PlayerController@indexPast'); 

Route::get('/major-league-teams', 'MajorLeagueTeamController@index')->name('major-league-teams.index');
Route::get('/major-league-teams/{majorLeagueTeam}', 'MajorLeagueTeamController@show')->name('major-league-teams.show');
Route::get('/major-league-teams/{majorLeagueTeam}/year/{year}', 'MajorLeagueTeamController@year')->name('major-league-teams.year');

Route::get('/minor-league-teams', 'MinorLeagueTeamController@index')->name('minor-league-teams.index');
Route::get('/minor-league-teams/{minorLeagueTeam}/{year}', 'MinorLeagueTeamController@show')->name('minor-league-teams.show');


// Route::get('/players/create', 'PlayerController@create');
// Route::get('/players/create/a', 'PlayerController@createA');
// Route::get('/players/create/aplus', 'PlayerController@createHighA');
// Route::get('/players/create/aa', 'PlayerController@createAA');
// Route::get('/players/create/aaa', 'PlayerController@createAAA');
