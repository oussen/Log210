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
Route::group(['middleware' => 'use.ssl'], function() {
// Book search & DB routes...
Route::post('rechercheLivre', ['as' => 'rechercheLivre', 'uses' => 'DatabaseController@rechercherLivre']);
Route::post('bookTransferReceive', ['as' => 'bookTransferReceive', 'uses' => 'DatabaseController@bookTransferReceive']);
Route::post('upcSearch', ['as' => 'upcSearch', 'uses' => 'APIController@getUpcBooks']);
Route::post('isbnSearch', ['as' => 'isbnSearch', 'uses' => 'APIController@getIsbnBooks']);
Route::post('eanSearch', ['as' => 'eanSearch', 'uses' => 'APIController@getEanBooks']);
Route::post('submitCoop', ['as' => 'submitCoop', 'uses' => 'DatabaseController@submitCoop']);
Route::post('joinCoop', ['as' => 'joinCoop', 'uses' => 'DatabaseController@joinCoop']);
Route::post('databaseBookEntry', ['as' => 'databaseBookEntry', 'uses' => 'DatabaseController@insertBookIntoDB']);
Route::get('ajoutDeLivres', ['as' => 'ajoutDeLivres', 'uses' => 'DatabaseController@checkLogin']);
Route::post('btnSearch', ['as' => 'btnSearch', 'uses' => 'DatabaseController@databaseGetBooks']);
Route::post('receiveBooks', ['as' => 'receiveBooks', 'uses' => 'DatabaseController@receiveBooks']);
Route::post('sendBooks', ['as' => 'sendBooks', 'uses' => 'DatabaseController@sendBooks']);
Route::post('findBooksForReservation', ['as' => 'findBooksForReservation', 'uses' => 'DatabaseController@findBooksForReservation']);
Route::post('reserveBook', ['as' => 'reserveBook', 'uses' => 'DatabaseController@reserveBook']);
Route::post('reservationEmail', ['as' => 'reservationEmail', 'uses' => 'DatabaseController@reservationEmail']);
Route::get('bookDelivery', ['as' => 'bookDelivery', 'uses' => 'DatabaseController@bookDelivery']);
Route::post('acceptDelivery', ['as' => 'acceptDelivery', 'uses' => 'DatabaseController@acceptDelivery']);
Route::post('declineDelivery', ['as' => 'declineDelivery', 'uses' => 'DatabaseController@declineDelivery']);


// Accessor routes...
	Route::get('home', ['as' => 'home', function () {
		if (Auth::guest()) {
			return Redirect::route('auth/login');
		} else {
			return view('welcome', ['user' => Auth::user()->name]);
		}
	}]);
	Route::get('ajoutDeLivres', ['as' => 'ajoutDeLivres', function () {
		if (Auth::guest()) {
			return Redirect::route('auth/login');
		} else {
			return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name]);
		}
	}]);
	Route::get('bookReservation', ['as' => 'bookReservation', function () {
		if (Auth::guest()) {
			return Redirect::route('auth/login');
		} else {
			return view('bookReservation', ['user' => Auth::user()->name]);
		}
	}]);
	Route::get('coopManagement', ['as' => 'coopManagement', 'uses' => 'Controller@displayCoop']);
	Route::get('receptionLivres', ['as' => 'receptionLivres', function () {
		return view('receptionLivres', ['user' => Auth::user()->name]);
	}]);
	Route::get('bookTransfer', ['as' => 'bookTransfer', 'uses' => 'DatabaseController@findBooksForTransferSend', function () {
		return view('bookTransfer', ['user' => Auth::user()->name]);
	}]);
	Route::get('bookTransferReceive', ['as' => 'bookTransferReceive', 'uses' => 'DatabaseController@findBooksForTransferReceive', function () {
		return view('bookTransferReceive', ['user' => Auth::user()->name]);
	}]);

// Authentication routes...
Route::get('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
});