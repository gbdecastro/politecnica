<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ChatController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

 //Retorna Perguntas e Respostas do User
public function index(){
  
  $id_usuario=Auth::user()->id_usuario;
  $hoje = Date('d-n-Y');

  $mensagens = DB::select(
      "SELECT * 
        FROM chat 
        WHERE id_usuario = $id_usuario
        ORDER BY id_msg DESC"
  );

  return view('chat.index',compact(['mensagens','hoje']));
} //index function end

   public function novaMensagem(Request $request){

            $id_usuario = $request->input('id_usuario');

            DB::table('users')
            ->where('id_usuario',$id_usuario)
            ->update([
              'nb_departamento'=> $request->input('nb_departamento')
            ]);
            
   } //public function end



  
  //class end  
}
