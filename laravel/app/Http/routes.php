<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('ajoutDeLivres', ['as' => 'ajoutDeLivres', 'uses' => 'Controller@checkLogin']);

Route::post('databaseBookEntry', ['as' => 'databaseBookEntry', 'uses' => 'Controller@store']);
Route::post('upcSearch', ['as' => 'upcSearch', 'uses' => 'Controller@getUpcBooks']);
Route::post('isbnSearch', ['as' => 'isbnSearch', 'uses' => 'Controller@getIsbnBooks']);
Route::post('eanSearch', ['as' => 'eanSearch', 'uses' => 'Controller@getEanBooks']);

Route::get('home', ['as' => 'home', function(){
	if (Auth::guest()){
		return Redirect::route('auth/login');
	} else {
		return view('welcome', ['user' => Auth::user()->name]);
	}
}]);

// Authentication routes...
Route::get('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');