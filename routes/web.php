<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('hotels', 'HomeController@hotels');
Route::get('activities', 'HomeController@activities');
Route::get('destinations', 'HomeController@destinations');

Route::get('packages/json/destinations/{continent?}/{country?}/{state?}',  'PackageController@jsonDestinations');
Route::get('packages/update/destinations',  'PackageController@updateDestinations');
Route::get('search-hotels', 'PackageController@getHotels');
Route::resource('packages', 'PackageController');


Auth::routes();

//Route::get('/home', 'HomeController@index')->middleware('auth');
