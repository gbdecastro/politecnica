<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Aval;
use Auth;

class AvalController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ano = (int) Date('Y');
        $mes = Date('n');
       
        $nb_ranking=Auth::user()->nb_ranking;
        $id_usuario=Auth::user()->id_usuario;
        
        $usuarios = DB::select(
                            "SELECT id_usuario, tx_name 
                            FROM v_funcionario
                            WHERE id_lotacao != 4
                            AND nb_ranking >=  $nb_ranking
                            AND id_usuario != $id_usuario
                            ORDER BY tx_name ASC"
                        );

        return view('aval.index', compact(['usuarios','ano','mes']));

    }
 //PAINEL Resumo Avaliacao
public function resumoAval(){

  $resumoAval = DB::select(
      "SELECT * 
        FROM v_user_aval
        ORDER BY tx_name ASC"
  );

  $lotacao = DB::select(
      "SELECT * 
        FROM lotacao
        ORDER BY id_lotacao ASC"
  );
  $anos = DB::select(
    "SELECT DISTINCT nb_ano
      FROM aval
      ORDER BY nb_ano DESC"
  );

  $ano = (int) Date('Y');
  $mes = Date('n');

  $meses = array("1"=>"Janeiro",
                            "2"=>"Fevereiro",
                            "3"=>"Março",
                            "4"=>"Abril",
                            "5"=>"Maio",
                            "6"=>"Junho",
                            "7"=>"Julho",
                            "8"=>"Agosto",
                            "9"=>"Setembro",
                            "10"=>"Outubro",
                            "11"=>"Novembro",
                            "12"=>"Dezembro"
);

  return view('painel.aval.index',compact(['resumoAval','lotacao','mes','ano','meses','anos']));
}
//PAINEL MODAL Resumo Anual do User Escolhido
public function resumoAnual($id_usuario,$ano)
    {
      $resumoAnual = DB::select(
        "SELECT a.id_f1, a.id_f2,a.nb_mes,a.nb_ano, a.nb_proativ,a.nb_produtiv,a.nb_pontual,u.tx_name
         FROM aval a
         INNER JOIN users u ON a.id_f1 = u.id_usuario
         WHERE a.id_f2 = $id_usuario AND a.nb_ano = $ano
         ORDER BY nb_mes ASC, tx_name ASC"
      );
     return $resumoAnual;

    } //public function end 

    public function mudaNota()
    {
    
     
    } //public function end 
    
   public function mudarColaborador(Request $request){
            $ano = Date('Y');
            $mes = Date('n');
            $idx = $request->input('former') - 1;

            DB::table('aval')
            ->where('id_f1',Auth::user()->id_usuario)
            ->where('nb_ano',$ano)
            ->where('nb_mes',$mes)
            ->where('nb_idx',$idx)
            ->update([
              'id_f2'=> $request->input('id_f2')
            ]);
            
   } //public function end 

   public function mudarProativ(Request $request){
    $ano = Date('Y');
    $mes = Date('n');
    $idx = $request->input('former') - 1;

    DB::table('aval')
    ->where('id_f1',Auth::user()->id_usuario)
    ->where('nb_ano',$ano)
    ->where('nb_mes',$mes)
    ->where('nb_idx',$idx)
    ->update([
      'nb_proativ'=> $request->input('nb_proativ')
    ]);
    
} //public function end 

public function mudarProdutiv(Request $request){
  $ano = Date('Y');
  $mes = Date('n');
  $idx = $request->input('former') - 1;

  DB::table('aval')
  ->where('id_f1',Auth::user()->id_usuario)
  ->where('nb_ano',$ano)
  ->where('nb_mes',$mes)
  ->where('nb_idx',$idx)
  ->update([
    'nb_produtiv'=> $request->input('nb_produtiv')
  ]);
  
} //public function end 

public function mudarPontual(Request $request){
  $ano = Date('Y');
  $mes = Date('n');
  $idx = $request->input('former') - 1;

  DB::table('aval')
  ->where('id_f1',Auth::user()->id_usuario)
  ->where('nb_ano',$ano)
  ->where('nb_mes',$mes)
  ->where('nb_idx',$idx)
  ->update([
    'nb_pontual'=> $request->input('nb_pontual')
  ]);
  
} //public function end 

   public function initAval($mes,$ano){
    $data = array();
    $entry = array();

     for($i = 0; $i < 10; $i++){

         $entry['id_f1'] = Auth::user()->id_usuario;
         $entry['id_f2'] = 0;
         $entry['nb_mes'] = $mes;
         $entry['nb_ano'] = $ano;
         $entry['nb_proativ'] = 0;
         $entry['nb_produtiv'] = 0;
         $entry['nb_pontual'] = 0;
         $entry['nb_idx'] = $i;
         $data[$i] = $entry;
     }

     DB::table('aval')->insert($data);

   }
   
   public function copyAval($mesant,$anoant){

    $table = DB::table('aval')
           ->select('id_f2','nb_idx')
           ->where('id_f1','=',Auth::user()->id_usuario)
           ->where('nb_mes','=',$mesant)
           ->where('nb_ano','=',$anoant)
           ->get();

    $mes = $mesant + 1;
    $ano = $anoant;
    if($mes == 13){
      $mes = 1;
      $ano = $ano + 1;
    }

    foreach($table as $entry){
            DB::table('aval')
            ->where('id_f1','=',Auth::user()->id_usuario)
            ->where('nb_mes','=',$mes)
            ->where('nb_ano','=',$ano)
            ->where('nb_idx','=',$entry->nb_idx)
            ->update(array('id_f2'=>$entry->id_f2));
    }
  
  }//public function end 

  public function trimAval($mesant,$anoant)  {
    DB::table('aval')
                 ->where('id_f1','=',Auth::user()->id_usuario)
                 ->where('nb_mes','=',$mesant)
                 ->where('nb_ano','=',$anoant)
                 ->where('id_f2','=',0)
                 ->delete();
    DB::table('aval')
                 ->where('id_f1','=',Auth::user()->id_usuario)
                 ->where('nb_mes','=',$mesant)
                 ->where('nb_ano','=',$anoant)
                 ->where('nb_proativ','=',0)
                 ->delete();
    DB::table('aval')
                 ->where('id_f1','=',Auth::user()->id_usuario)
                 ->where('nb_mes','=',$mesant)
                 ->where('nb_ano','=',$anoant)
                 ->where('nb_produtiv','=',0)
                 ->delete();
    DB::table('aval')
                 ->where('id_f1','=',Auth::user()->id_usuario)
                 ->where('nb_mes','=',$mesant)
                 ->where('nb_ano','=',$anoant)
                 ->where('nb_pontual','=',0)
                 ->delete();             
  }//public function end 

    public function situacaoAtual()
    {
        $ano = (int) Date('Y');
        $mes = (int) Date('n');
        $anoant = $ano;
        $mesant = $mes - 1;
            if($mesant == 0){
              $mesant = 12;
              $anoant = $anoant - 1;
              }
        //verifica entradas atuais
        $atual = Aval::where('id_f1','=',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->count();

       if ($atual == 0){
         //inicia com inserts para o usuario atual no mes atual 
       Self::initAval($mes, $ano);
       
         //verifica entradas mes passado
        $passado = Aval::where('id_f1','=',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mesant)
        ->where('nb_ano','=',$anoant)
        ->count();

         if($passado != 0){
            //limpa o mes passado
             Self::trimAval($mesant,$anoant);
            //faz updates com os nomes dos usuarios já mencionados
             Self::copyAval($mesant,$anoant);
             }   

        }
    
       // return 'avalok';
       return  DB::table('aval')
        ->select('id_f2','nb_proativ','nb_produtiv','nb_pontual','nb_idx')
        ->where('id_f1','=',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

    }  //public function end
  //class end  
}
