<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use View, Auth, Redirect, DB;

class DatabaseController extends BaseController
{

    /**
     * Searches our DB for the book on add book page
     *
     * @param Request $request
     * @return Make the according view, with info or without
     */
    public function databaseGetBooks(Request $request){
        $data = $request->get('isbnText');

        $data = DB::table('livres')->where('codeISBN', $data)
            ->orWhere('codeUPC', $data)
            ->orWhere('codeEAN', $data)
            ->get();

        if(!empty($data)){
            return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'dataDB' => $data[0]]);}
        else
            return View::make('ajoutDeLivres')->with(['user' => Auth::user()->name, 'dataDB' => ""]);
    }

    /**
     * Searches our DB for the book on add receive book page
     *
     * @param Request $request
     * @return Make the according view, with info or without
     */
    public function rechercherLivre(Request $request)
    {
        $data = $request->all();
        $isbn = "";
        $title = "~";
        $id = "";

        if(!empty($data['isbnText'])){
            $isbn = $data['isbnText'];
        }
        if(!empty($data['titreText'])){
            $title = $data['titreText'];
        }
        if(!empty($data['studentName'])){
            $user_id = DB::table('users')->select('id')->where('name', $data['studentName'])->get();
            if(!empty($user_id))
                $id = $user_id[0]->id;
        }

        /**
         * Si vous voulez utiliser cette query comme exemple, elle produit:
         *
         * SELECT livres.*, users.email FROM livres
         *  INNER JOIN users
         *  ON livres.idUSER = users.id
         *  WHERE livres.recu <> 1
         *  AND (
         *        WHERE livres.codeISBN = $isbn
         *        OR WHERE livres.codeUPC = $isbn
         *        OR WHERE livres.codeEAN = $isbn
         *        OR WHERE livres.title LIKE '%'.$title.'%'
         *        OR WHERE livres.idUSER = $id
         *      );
         */
        $data = DB::table('livres')
            ->join('users', 'livres.idUSER', '=', 'users.id')
            ->select('livres.*', 'users.email')
            ->where('livres.recu', '<>', 1)
            ->where(function($query) use ($isbn, $title, $id){
                $query->where('livres.codeISBN', $isbn)
                    ->orWhere('livres.codeUPC', $isbn)
                    ->orWhere('livres.codeEAN', $isbn)
                    ->orWhere('livres.titre', 'like', '%'.$title.'%')
                    ->orWhere('livres.idUSER', $id);
            })
            ->get();

        if(!empty($data)) {
            return View::make('receptionLivres')->with(['user' => Auth::user()->name, 'dataDB' => $data]);
        }
        else {
            return View::make('receptionLivres')->with(['user' => Auth::user()->name, 'dataDB' => ""]);
        }
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
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0]);
            } elseif($data['whatIs'] == "upc"){
                DB::table('livres')->insert(['codeUPC' => $data['isbn'], 'titre' => $data['title'],
                    'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0]);
            }elseif($data['whatIs'] == "ean"){
                DB::table('livres')->insert(['codeEAN' => $data['isbn'], 'titre' => $data['title'],
                    'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0]);
            }

        }
    }

    /**
     * Handles submission of Coops
     *
     * @param Request $request
     * @return Redirect to coop page (refresh)
     */
    public function submitCoop(Request $request){

        $data = $request->all();

        DB::table('coop')->insert(['address' => $data['coopAddress'], 'name' => $data['coopName'], 'idMANAGER' => Auth::user()->id]);
        $currentCoop = DB::table('coop')->select('id')->where('name', $data['coopName'])->get();
        DB::table('users')->where('id', Auth::user()->id)->update(['idCOOP' => $currentCoop[0]->id]);

        return Redirect::route('coopManagement');
    }

    /**
     * Handles joining of Coops
     *
     * @param Request $request
     * @return Redirect to coop page (refresh)
     */
    public function joinCoop(Request $request){
        $data = $request->all();

        DB::table('users')->where('id', Auth::user()->id)->update(['idCOOP' => $data['coopSelected']]);
        return Redirect::route('coopManagement');
    }

    /**
     * Handles receiving of books
     *
     * @param Request $request
     * @return Redirect to receive books page (refresh)
     */
    public function receiveBooks(Request $request){
        $data = $request->get("id");

        DB::table('livres')->where('id', $data)->update(['recu' => "1"]);
        return Redirect::route('receptionLivres');
    }
}