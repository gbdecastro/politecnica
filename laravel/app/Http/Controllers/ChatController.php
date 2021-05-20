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
      "SELECT id_usuario, id_msg, DATE_FORMAT(dt_envio, '%d/%m/%Y') AS dt_envio, DATE_FORMAT(dt_resposta, '%d/%m/%Y') AS dt_resposta, tx_envio, tx_resposta, tx_titulo 
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
    "SELECT ch.id_usuario, ch.id_msg, DATE_FORMAT(ch.dt_envio, '%d/%m/%Y') AS dt_envio, DATE_FORMAT(ch.dt_resposta, '%d/%m/%Y') AS dt_resposta, ch.tx_envio, ch.tx_resposta, ch.tx_titulo , u.id_lotacao, u.tx_name, l.tx_lotacao
      FROM chat  ch 
      INNER JOIN users u ON u.id_usuario = ch.id_usuario
      INNER JOIN lotacao l ON l.id_lotacao = u.id_lotacao
      ORDER BY ch.id_msg DESC"
      );

  return view('painel/chat.index',compact(['lotacao','mensagens']));
}// centralChat End

//Request de post para Nova mensagem do User
public function novaMensagem(Request $request){
            $response = array();
            $id_usuario = Auth::user()->id_usuario;
            $dt_envio = Date('Y-n-d');
            $tx_titulo = $request->input('tx_titulo');
            $tx_envio = $request->input('tx_envio');

            if($tx_titulo == ''){
              $response[0] = 1;
              $response[1] = "Erro! Favor Preencher o Título!";
              return $response;
            }
            else if($tx_envio == ''){
              $response[0] = 1;
              $response[1] = "Erro! Caixa de Mensagem Vazia!";
              return $response;      
              
            }
            else{
            DB::table('chat')
              ->insert([
                [
                    'id_usuario' => $id_usuario,
                    'dt_envio' => $dt_envio,
                    'tx_titulo' => $tx_titulo,
                    'tx_envio' => $tx_envio
                ]
              ]);
              $response[0] = 0;
              $response[1] = "Mensagem Enviada com Sucesso!";
              return $response;     
              
            }
            
   } //public function end

   public function removeMensagem(Request $request){

        $id_msg = $request->input('id_msg');

        DB::table('chat')
        ->where('id_msg',$id_msg)
        ->delete();

        return "Mensagem Removida com Sucesso!";
   } //public function end

  public function responderMensagem(Request $request){
    
    $dt_resposta = Date('Y-n-d');

    DB::table('chat')
    ->where('id_msg',$request->input('id_msg'))
    ->update([
      'tx_resposta'=>$request->input('tx_resposta'),
      'dt_resposta'=>$dt_resposta
            ]);

      return "Resposta Enviada com Sucesso!";
  }//public function end
 
  //class end  
}
