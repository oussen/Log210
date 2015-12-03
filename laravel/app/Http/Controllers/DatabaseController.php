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
        $dataDB = DB::table('livres')
            ->join('users', 'livres.idUSER', '=', 'users.id')
            ->select('livres.*', 'users.email')
            ->where('livres.recu', '<>', 1)
            ->where('livres.is_sold', '<>', 1)
            ->where(function($query) use ($isbn, $title, $id){
                $query->where('livres.codeISBN', $isbn)
                    ->orWhere('livres.codeUPC', $isbn)
                    ->orWhere('livres.codeEAN', $isbn)
                    ->orWhere('livres.titre', 'like', '%'.$title.'%')
                    ->orWhere('livres.idUSER', $id);
            })
            ->get();


        if (!empty($dataDB)) {
            return View::make('receptionLivres')->with(['user' => Auth::user()->name, 'dataDB' => $dataDB]);
        } else {
            return View::make('receptionLivres')->with(['user' => Auth::user()->name, 'dataDB' => ""]);
        }
    }

    public function findBooksForReservation(Request $request)
    {
        $data = $request->all();
        $isbn = "";
        $title = "~";
        $author = "~";

        if(!empty($data['isbnText'])){
            $isbn = $data['isbnText'];
        }
        if(!empty($data['titreText'])){
            $title = $data['titreText'];
        }
        if(!empty($data['authorName'])){
            $author = $data['authorName'];
        }

        $dataDB = DB::table('livres')
            ->join('users', 'livres.idUSER', '=', 'users.id')
            ->select('livres.*', 'users.email')
            ->where('livres.recu', 1)
            ->where('livres.is_reserved', 0)
            ->where('livres.is_sold', '<>', 1)
            ->where(function($query) use ($isbn, $title, $author){
                $query->where('livres.codeISBN', $isbn)
                    ->orWhere('livres.codeUPC', $isbn)
                    ->orWhere('livres.codeEAN', $isbn)
                    ->orWhere('livres.titre', 'like', '%'.$title.'%')
                    ->orWhere('livres.auteur', 'like', '%'.$author.'%');
            })
            ->get();

        if (!empty($dataDB)) {
            return View::make('bookReservation')->with(['user' => Auth::user()->name, 'dataDB' => $dataDB, 'emptyData' => 'false']);
        } else {
            return View::make('bookReservation')->with(['user' => Auth::user()->name, 'dataDB' => "", 'emptyData' => 'true']);
        }
    }

    public function findBooksForTransferSend()
    {
        $dataDB = DB::table('livres')
            ->join('expedition', 'livres.id', '=', 'expedition.idBOOK')
            ->select('livres.*')
            ->where('expedition.isDone', 0)
            ->where('expedition.isExpedited', 0)
            ->where('livres.is_sold', '<>', 1)
            ->where('livres.recu', 0)
            ->where('livres.idCOOP', Auth::user()->idCOOP)
            ->get();

        if (!empty($dataDB)) {
            return View::make('bookTransfer')->with(['user' => Auth::user()->name, 'dataDB' => $dataDB, 'emptyData' => 'false']);
        } else {
            return View::make('bookTransfer')->with(['user' => Auth::user()->name, 'dataDB' => "", 'emptyData' => 'true']);
        }
    }

    public function findBooksForTransferReceive()
    {
        $dataDB = DB::table('livres')
            ->join('expedition', 'livres.id', '=', 'expedition.idBOOK')
            ->select('livres.*')
            ->where('expedition.isDone', 0)
            ->where('expedition.isExpedited', 1)
            ->where('livres.is_sold', '<>', 1)
            ->where('livres.recu', 0)
            ->where('expedition.idCoopTo', Auth::user()->idCOOP)
            ->get();

        if (!empty($dataDB)) {
            return View::make('bookTransferReceive')->with(['user' => Auth::user()->name, 'dataDB' => $dataDB, 'emptyData' => 'false']);
        } else {
            return View::make('bookTransferReceive')->with(['user' => Auth::user()->name, 'dataDB' => "", 'emptyData' => 'true']);
        }
    }

    public function bookTransferReceive(Request $request)
    {
        $data = $request->get('id');

        DB::table('livres')->where('id', $data)->update(['recu' => '1' ,'idCOOP' => Auth::user()->idCOOP]);
        DB::table('expedition')->where('idBOOK', $data)->update(['isExpedited' => '1', 'isDone' => '1']);

        //mail("projet.log210.01@gmail.com", "Votre livre est arriv�!", "Vous avez 48 heures pour venir chercher votre livre.");
    }

    public function sendBooks(Request $request)
    {
        $data = $request->get('id');
        DB::table('expedition')->where('idBOOK', $data)->update(['isExpedited' => "1"]);
        DB::table('livres')->where('id', $data)->update(['recu' => 0]);
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
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0, 'idCOOP' => $data['userCoopID'], 'is_sold' => 0]);
            } elseif($data['whatIs'] == "upc"){
                DB::table('livres')->insert(['codeUPC' => $data['isbn'], 'titre' => $data['title'],
                    'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0, 'idCOOP' => $data['userCoopID'], 'is_sold' => 0]);
            }elseif($data['whatIs'] == "ean"){
                DB::table('livres')->insert(['codeEAN' => $data['isbn'], 'titre' => $data['title'],
                    'auteur' => $data['author'], 'nombrePages' => $data['pageCount'],
                    'prix' => $data['price'], 'condition' => $data['bookState'], 'idUSER' => Auth::user()->id, 'recu' => 0, 'idCOOP' => $data['userCoopID'], 'is_sold' => 0]);
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

        return Redirect::route('home');
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
        return Redirect::route('home');
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

        //verifier si un etudiant avait l'intention d'etre notifier pour ce livre
        /*$bookInfo = DB::table('livres')->select('codeISBN', 'codeUPC', 'codeEAN')->where('id', $data)->get();

        if(!is_null($bookInfo[0]['codeISBN']))
            $codeISBN = $bookInfo[0]['codeISBN'];
        elseif(!is_null($bookInfo[0]['codeUPC']))
            $codeISBN = $bookInfo[0]['codeUPC'];
        elseif(!is_null($bookInfo[0]['codeEAN']))
            $codeISBN = $bookInfo[0]['codeEAN'];

        $userID = DB::table('notifications')->where('codeISBN', $codeISBN)
                                            ->value('idUSER');
        if (!is_null($userID)){
            $userCoopID = DB::table('users')->where('id', $userID)->value('idCOOP');
            if($userCoopID == Auth::user()->idCOOP){
                //mail("projet.log210.01@gmail.com", "Votre livre est arriv�!", "Vous pouvez venir chercher votre livre.");
                print_r("Worked!");
                die();
            }
        }*/
    }

    public function reserveBook(Request $request){
        if($request->ajax()) {
            $data = $request->all();

            $timestamp = date('Y-m-d H:i:s', strtotime($data['reservedUntil']));

            if($data['isTransfer'] == true)
            {
                DB::table('expedition')->insert(['idBOOK' => $data['bookID'], 'idCoopFrom' => $data['coopID'], 'idCoopTo' => Auth::user()->idCOOP]);
                DB::table('livres')->where('id', $data['bookID'])->update(['recu' => '0']);
            }

            DB::table('reservations')->insert(['idUSER' => $data['userID'], 'idBOOK' => $data['bookID'], 'date_reserved_until' => $timestamp, 'idCOOP' => Auth::user()->idCOOP]);
            DB::table('livres')->where('id', $data['bookID'])->update(['is_reserved' => true]);
        }
    }

    public function reservationEmail(Request $request){
        $data = $request->all();

        DB::table('notifications')->insert(['idUSER' => $data['userID'], 'codeISBN' => $data['isbnNumber']]);
        Return View::make('bookReservation')->with(['user' => Auth::user()->name, 'confirmationEmailDone' => 'true']);
    }

    public function bookDelivery(){
        $data = DB::table('reservations')->select('idUSER', 'idBOOK')->where('idCOOP', Auth::user()->idCOOP)->get();
        $count = 0;
        $askingUserID = "";

        if(!empty($data)) {
            foreach ($data as $book) {
                foreach ($book as $key => $value) {
                    if ($key == 'idUSER') {
                        $askingUserID = $value;
                    }
                    if ($key == 'idBOOK') {
                        $dataDB[$count] = DB::table('livres')->where('id', $value)->get();
                        $count++;
                    }
                }
            }

            return View::make('bookDelivery')->with(['user' => Auth::user()->name, 'dataDB' => $dataDB, 'askingUserID' => $askingUserID]);
        } else {
            return View::make('bookDelivery')->with(['user' => Auth::user()->name, 'dataDB' => "", 'askingUserID' => $askingUserID]);
        }
    }

    public function acceptDelivery(Request $request){
        $data = $request->all();

        DB::table('livres')->where('id', $data['bookID'])->update(['is_sold' => 1]);

        DB::table('reservations')->where('idUSER', $data['userID'])
                                ->where('idBOOK', $data['bookID'])
                                ->delete();

        return View::make('bookDelivery')->with(['user' => Auth::user()->name, 'delivery' => 'success']);
    }

    public function declineDelivery(Request $request){
        $data = $request->all();

        DB::table('livres')->where('id', $data['bookID'])->update(['is_reserved' => 0]);

        DB::table('reservations')->where('idUSER', $data['userID'])
            ->where('idBOOK', $data['bookID'])
            ->delete();

        return View::make('bookDelivery')->with(['user' => Auth::user()->name, 'delivery' => 'failure']);
    }

}