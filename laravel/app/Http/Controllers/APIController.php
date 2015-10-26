<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use View, Auth;

class APIController extends BaseController
{
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
}