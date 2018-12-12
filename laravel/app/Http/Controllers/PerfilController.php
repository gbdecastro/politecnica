<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    public function index(){
        //Pegando a Lotação
        $usuario = DB::table('v_funcionario')->where('id_usuario','=',Auth::user()->id_usuario)->get();        
        $usuario = $usuario[0];
	    return view('perfil.index', compact(['usuario']));
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
