<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use View;
use Auth;
use Redirect;
use Input;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Sends a json request to a UPC database API
	 * Returns with json string of all info available
	 *
	 * @param Request $request -> in this case UPC number
	 * @return View 'ajoutDeLivres' with Username and json array of api result
	 */
	public function getUpcBooks(Request $request){

		$isbn = $request->get('isbnText');

		$json = $this->getContentDataAttribute(file_get_contents('http://api.upcdatabase.org/json/9b2028c160f324a5a0ed889f07394e5d/' . $isbn));

		//return $json;

		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonUPC' => $json]);
	}

	/**
	 * Sends a json request to an ISBN database API
	 * Returns with json string of all info available
	 *
	 * @param Request $request -> in this case ISBN number
	 * @return View 'ajoutDeLivres' with Username and json array of api result
	 */
	public function getIsbnBooks(Request $request){

		$isbn = $request->get('isbnText');

		$json = $this->getContentDataAttribute(file_get_contents("https://www.googleapis.com/books/v1/volumes?q=+isbn:".
																	$isbn.
																	"&key=AIzaSyBbtI1mN-lvCzHQrCxVel47M9IF4I9udL0&fiel".
																	"ds=items/volumeInfo(title,authors,pageCount,indus".
																	"tryIdentifiers),items/saleInfo/retailPrice/amount"));

		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonISBN' => $json]);
	}

	/**
	 * Sends a json request to an EAN database API
	 * Returns with json string of all info available
	 *
	 * @param Request $request -> in this case EAN number
	 * @return View 'ajoutDeLivres' with Username and json array of api result
	 */
	public function getEanBooks(Request $request){

		$isbn = $request->get('isbnText');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://api.outpan.com//v1/products/" . $isbn . "/name");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_USERPWD, "0b8512a6b0bbaeae7977c53ce3157eb6:");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$json = curl_exec($curl);
		$json = $this->getContentDataAttribute($json);

		//return $json;

		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonEAN' => $json]);
	}

	/**
	 * Decodes the json string and returns as an array
	 *
	 * @param $data -> json string from API
	 * @return array from json
	 */
	public function getContentDataAttribute($data){
		return json_decode($data, true);
	}

	public function databaseGetBooks(Request $request){
			$data = $request->get('isbnText');
			$data = DB::table('livres')->where('codeISBN', $data)
							   ->orWhere('codeUPC', $data)
							   ->orWhere('codeEAN', $data)
							   ->get();

			if(!emptyArray($data))
				return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'dataDB' => $data[0]]);
			else
				return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'dataDB' => ""]);
	}

	/**
	 * Handles inserts into DB for all code types
	 *
	 * @param Request $request
	 */
	public function insertBookIntoDB(Request $request){
		if($request->ajax()){
			$data = $request->all();

			if($data['whatIs'] == "isbn"){
				DB::table('livres')->insert(['codeISBN' => $data['isbn'], 'titre' => $data['title'],
					'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
					'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id]);
			} elseif($data['whatIs'] == "upc"){
				DB::table('livres')->insert(['codeUPC' => $data['isbn'], 'titre' => $data['title'],
					'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
					'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id]);
			}elseif($data['whatIs'] == "ean"){
				DB::table('livres')->insert(['codeEAN' => $data['isbn'], 'titre' => $data['title'],
					'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
					'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id]);
			}

		}
	}

	public function displayCoop(){
		if (Auth::guest()){
			return Redirect::route('auth/login');
		} else {
			$coop = DB::table('coop')->select('id', 'name')->get();
			return view('coopManagement', ['user' => Auth::user()->name, 'coop' => $coop]);
		}
	}

	public function submitCoop(Request $request){

		$data = $request->all();

		DB::table('coop')->insert(['address' => $data['coopAddress'], 'name' => $data['coopName'], 'idMANAGER' => Auth::user()->id]);
		return Redirect::route('coopManagement');
	}

	public function joinCoop(Request $request){
		$data = $request->all();

		DB::table('users')->where('id', Auth::user()->id)->update(['idCOOP' => $data['coopSelected']]);
		return Redirect::route('coopManagement');
	}
}
