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
	
	public function checkLogin()
	{
		if (Auth::guest()){
			return Redirect::route('auth/login');
		} else {
			return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name]);
		}
	}

	public function getUpcBooks(Request $request){

		$isbn = $request->get('isbnText');

		$json = $this->getContentDataAttribute(file_get_contents('http://api.upcdatabase.org/json/9b2028c160f324a5a0ed889f07394e5d/' . $isbn));

		//return $json;

		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonUPC' => $json]);
	}

	public function getIsbnBooks(Request $request){

		$isbn = $request->get('isbnText');

		$json = $this->getContentDataAttribute(file_get_contents("https://www.googleapis.com/books/v1/volumes?q=+isbn:" . $isbn . "&key=AIzaSyBbtI1mN-lvCzHQrCxVel47M9IF4I9udL0&fields=items/volumeInfo(title,authors,pageCount,industryIdentifiers),items/saleInfo/retailPrice/amount"));

		//return $json;

		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'jsonISBN' => $json]);
	}

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

	public function getContentDataAttribute($data){
		return json_decode($data, true);
	}

	public function databaseGetBooks(Request $request){
			$data = $request->get('isbnText');
			$data = DB::table('livres')->where('codeISBN', $data)
							   ->orWhere('codeUPC', $data)
							   ->orWhere('codeEAN', $data)
							   ->get();
		
		return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'dataDB' => $data[0]]);
	}
	
	
	public function store(Request $request){
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
}
