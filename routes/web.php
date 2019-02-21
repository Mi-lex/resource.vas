<?php

// Home page
Route::get('/', 'MainController@home');

// Device{
Route::get('/meters/{meter}', 'MetersController@show');

Route::get('/meters/{meter}/consumption/{days}', 'MetersController@consumption');

Route::get('/meters/{meter}/last_electricity_consumption', 'MetersController@last_electricity_consumption');
