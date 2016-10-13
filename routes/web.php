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

Route::get('/', 'FrontendController@index');
Route::get('about', 'FrontendController@about');
Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware'=>'auth'], function () {
  Route::get('/', 'AdminController@index');
  Route::get('hotels', 'AdminController@hotels');
  Route::get('activities', 'AdminController@activities');
  Route::get('destinations', 'AdminController@destinations');
  Route::get('packages/json/destinations/{continent?}/{country?}/{state?}',  'PackageController@jsonDestinations');
  Route::get('packages/update/destinations',  'PackageController@updateDestinations');
  Route::get('search-hotels', 'PackageController@getHotels');
  Route::get('search-activities', 'PackageController@getActivities');
  Route::post('save-package', 'PackageController@ajaxSavePackage');
  Route::get('categories/all', 'CategoryController@ajaxGetAll');
  Route::resource('packages', 'PackageController');
  Route::resource('categories', 'CategoryController');
  Route::resource('customers', 'CustomerController');
  Route::get('get-package/{id}', 'PackageController@ajaxGetPackage');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->middleware('auth');
