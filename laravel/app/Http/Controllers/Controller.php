<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;
use Auth;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function getBooks()
	{
		$books = DB::table('livres')->get();

		if (Auth::guest()){
			return redirect('auth/login');
		} else {
			return View::make('ajoutDeLivres')->with(['books' => $books, 'user' => Auth::user()->name]);
		}
	}
}
