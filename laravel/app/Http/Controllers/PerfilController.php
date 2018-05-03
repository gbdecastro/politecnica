<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
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

    public function alterarSenha(Request $request)
    {
        $senha = bcrypt($request->input('tx_senha'));

        $user = User::find(Auth::user()->id_usuario);
        $user->tx_password = $senha;
        $user->save();

        return Auth::logout();
        
    }
}
