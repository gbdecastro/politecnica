<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class RankingController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

 //PAINEL Resumo Organograma
public function resumoRanking(){

  $resumoRanking = DB::select(
      "SELECT id_usuario, id_lotacao, tx_name, nb_departamento, nb_ranking 
        FROM users
        ORDER BY tx_name ASC"
  );

  $lotacao = DB::select(
      "SELECT * 
        FROM lotacao
        ORDER BY id_lotacao ASC"
  );

  return view('painel.ranking.index',compact(['resumoRanking','lotacao']));
}

   public function mudarDepartamento(Request $request){

            $id_usuario = $request->input('id_usuario');

            DB::table('users')
            ->where('id_usuario',$id_usuario)
            ->update([
              'nb_departamento'=> $request->input('nb_departamento')
            ]);
            
   } //public function end

   public function mudarRanking(Request $request){

    $id_usuario = $request->input('id_usuario');

    DB::table('users')
    ->where('id_usuario',$id_usuario)
    ->update([
      'nb_ranking'=> $request->input('nb_ranking')
    ]);
    
} //public function end 

  public function situacaoAtual()
    {
         
       // return 'avalok';
       return  DB::table('users')
        ->select('id_usuario','nb_departamento','nb_ranking')
        ->get();

    }  //public function end
  //class end  
}
