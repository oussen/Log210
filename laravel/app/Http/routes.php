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
Route::post('btnSearch', ['as' => 'btnSearch', 'uses' => 'Controller@databaseGetBooks']);

// Book search & DB routes...
Route::post('upcSearch', ['as' => 'upcSearch', 'uses' => 'Controller@getUpcBooks']);
Route::post('isbnSearch', ['as' => 'isbnSearch', 'uses' => 'Controller@getIsbnBooks']);
Route::post('eanSearch', ['as' => 'eanSearch', 'uses' => 'Controller@getEanBooks']);
Route::post('submitCoop', ['as' => 'submitCoop', 'uses' => 'Controller@submitCoop']);
Route::post('joinCoop', ['as' => 'joinCoop', 'uses' => 'Controller@joinCoop']);
Route::post('databaseBookEntry', ['as' => 'databaseBookEntry', 'uses' => 'Controller@insertBookIntoDB']);

// Accessor routes...
Route::get('home', ['as' => 'home', function(){
	if (Auth::guest()){
		return Redirect::route('auth/login');
	} else {
		return view('welcome', ['user' => Auth::user()->name]);
	}
}]);
Route::get('ajoutDeLivres', ['as' => 'ajoutDeLivres', function(){
	if (Auth::guest()){
		return Redirect::route('auth/login');
	} else {
		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name]);
	}
}]);
Route::get('coopManagement', ['as' => 'coopManagement', 'uses' => 'Controller@displayCoop']);

// Authentication routes...
Route::get('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');