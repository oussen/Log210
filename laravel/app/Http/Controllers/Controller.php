<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View, Auth, Redirect, DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function displayCoop(){
		if (Auth::guest()){
			return Redirect::route('auth/login');
		} else {
			$coop = DB::table('coop')->select('id', 'name')->get();
			return view('coopManagement', ['user' => Auth::user()->name, 'coop' => $coop]);
		}
	}
}
