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

// Book search & DB routes...
Route::post('rechercheLivre', ['as' => 'rechercheLivre', 'uses' => 'Controller@rechercherLivre']);
Route::post('upcSearch', ['as' => 'upcSearch', 'uses' => 'Controller@getUpcBooks']);
Route::post('isbnSearch', ['as' => 'isbnSearch', 'uses' => 'Controller@getIsbnBooks']);
Route::post('eanSearch', ['as' => 'eanSearch', 'uses' => 'Controller@getEanBooks']);
Route::post('submitCoop', ['as' => 'submitCoop', 'uses' => 'Controller@submitCoop']);
Route::post('joinCoop', ['as' => 'joinCoop', 'uses' => 'Controller@joinCoop']);
Route::post('databaseBookEntry', ['as' => 'databaseBookEntry', 'uses' => 'Controller@insertBookIntoDB']);
Route::get('ajoutDeLivres', ['as' => 'ajoutDeLivres', 'uses' => 'Controller@checkLogin']);
Route::post('databaseBookEntry', ['as' => 'databaseBookEntry', 'uses' => 'Controller@store']);
Route::post('btnSearch', ['as' => 'btnSearch', 'uses' => 'Controller@databaseGetBooks']);
Route::post('receiveBooks', ['as' => 'receiveBooks', 'uses' => 'Controller@receiveBooks']);

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
Route::get('receptionLivres', ['as' => 'receptionLivres', function(){
	return view('receptionLivres', ['user' => Auth::user()->name]);
}]);

// Authentication routes...
Route::get('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');