<?php

// Home page
Route::get('/', 'MainController@home');

// Device{
Route::get('/meters/{meter}', 'MetersController@show');

Route::get('/meters/{meter}/consumption/{days}', 'MetersController@consumption');

// Consumptions

Route::get('/meters/{meter}/last_consumption', 'MetersController@last_consumption');

Route::get('/meters/{meter}/last_electricity_consumption', 'MetersController@last_electricity_consumption');

// District

Route::get('/districts/{district}', 'DistrictsController@show');

// Sector

Route::get('/sectors/{sector}', 'SectorsController@show');

// Object

Route::get('/objects/{object}', 'ObjectsController@show');

// Building

Route::get('/buildings/{building}', 'BuildingsController@show');

// Game

Route::get('/games/sapper', 'GamesController@sapper');

// Monitoring

Route::get('/meters/{meter}/monitoring', 'MetersController@monitoring');

// Driver

Route::get('/meters/{meter}/driver', 'DriversController@params');

// Request electricity devices and write their consumptions
Route::get('/meters/write/electricity', 'DriversController@write_electricity');


