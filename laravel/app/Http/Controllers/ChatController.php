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

//Retorna Painel de Geral das Mensagens para O ADMIN
public function centralChat(){
  $lotacao = DB::select(
    "SELECT * 
      FROM lotacao
      ORDER BY id_lotacao ASC"
  );

  $mensagens = DB::select(
    "SELECT ch.* , u.id_lotacao, u.tx_name, l.tx_lotacao
      FROM chat  ch 
      INNER JOIN users u ON u.id_usuario = ch.id_usuario
      INNER JOIN lotacao l ON l.id_lotacao = u.id_lotacao
      ORDER BY ch.id_msg DESC"
      );

  return view('painel/chat.index',compact(['lotacao','mensagens']));
}// centralChat End

//Request de post para Nove mensagem do User
public function novaMensagem(Request $request){

            $id_usuario = $request->input('id_usuario');

            DB::table('users')
            ->where('id_usuario',$id_usuario)
            ->update([
              'nb_departamento'=> $request->input('nb_departamento')
            ]);
            
   } //public function end

   public function apagarMensagem(Request $request){

        DB::table('chat')
        ->where('id_msg',$id_msg)
        ->delete();
   } //public function end

  public function responderMensagem(Request $request){

    DB::table('chat')
    ->where('id_msg',$id_msg)
    ->update([
      'tx_resposta'=>$request->input('tx_resposta')
      ]);
  }
  //class end  
}
