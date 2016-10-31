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
Route::get('category/{id}', 'FrontendController@category');
Route::get('category/{categoryId}/package/{id}/{option?}/{parameter?}', 'FrontendController@package');
Route::get('static-package/{option?}/{parameter?}','FrontendController@staticPackage');
Route::get('hotel/{id}','FrontendController@getHotel');
Route::get('payment','FrontendController@payment')->middleware('customer');
Route::post('payment',  'FrontendController@makePayment')->name('payment')->middleware('customer');
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
  Route::resource('purchases', 'PurchaseController');
  Route::get('get-package/{id}', 'PackageController@ajaxGetPackage');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->middleware('auth');

//Customer Login
Route::get('customer/login', 'CustomerAuth\LoginController@showLoginForm');
Route::post('customer/login', 'CustomerAuth\LoginController@login');
Route::post('customer/logout', 'CustomerAuth\LoginController@logout');

//Customer Register
Route::get('customer/register', 'CustomerAuth\RegisterController@showRegistrationForm');
Route::post('customer/register', 'CustomerAuth\RegisterController@register');

//Customer Passwords
Route::post('customer/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail');
Route::post('customer/password/reset', 'CustomerAuth\ResetPasswordController@reset');
Route::get('customer/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm');
Route::get('customer/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');

//Shopping Cart
Route::group(['middleware'=>'customer'], function () {
    Route::get('cart/', 'CartController@index')->name('cart.index');
    Route::post('cart/', 'CartController@add')->name('cart.add');
    Route::delete('cart/{rowId}', 'CartController@destroy')->name('cart.destroy');
});
