<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    public function index(){

	    return view('perfil.index');
    }

    public function foto(Request $request){

        //$extension = $request->file('file')->getClientOriginalExtension();
        $filename = hash('sha256',Auth::user()->id_usuario);
        $request->file('file')->move('img/user/',$filename.'.png');
    }
}
