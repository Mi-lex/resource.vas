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
Route::get('/meters/{meter}/driver', 'DriversController@show');

// Params
Route::get('/meters/{meter}/params', 'DriversController@params');

// Request electricity devices and write their consumptions
Route::get('/meters/write/{type}', 'DriversController@write');


/**
 * Electricity devices
 * 
 * old ones | new ones
 *     9        8 ('Ввод 2')    
 *     8        7 ('Ввод 1')
 *     7        6 ("Распределительная панель 2")
 *     6        5 ("Распределительная панель 4")
 *     5        4 ("Аварийная панель 5")
 *     4        3 ("ЦОД  резервный ввод")
 *     2        2 ("ЦОД  основной ввод")
 * 
 * Water meters
 * 
 * old ones | new ones
 *     19       id: 25, name: "ВУ-4 ГП-4 хозбытовая",
 *     17       id: 23 "ВУ-5 ГП-4 хозбытовая",
 *     16       id: 22, name: "ВУ-7 ГП-5 пожарная",
 *     15       id: 21, name: "ВУ-7 ГП-5 хозбытовая",
 *     14       id: 20, name: "ВУ-6 ГП-5 пожарная",
 *     13       id: 19, name: "ВУ-6 ГП-5 хозбытовая",
 */


