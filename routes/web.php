<?php

// Home page
Route::get('/', 'MainController@home');

// Device{
Route::get('/meters/{meter}', 'MetersController@show');

Route::get('/meters/{meter}/consumption/{days}', 'MetersController@consumption');
