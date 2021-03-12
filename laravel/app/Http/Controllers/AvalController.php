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
       
      //  $usuarios = DB::table('v_funcionario')
        //                ->select('id_usuario','tx_name')
          //              ->where('id_lotacao','=!','4')
            //            ->orderBy('tx_name', 'asc')
              //          ->get();        

        $usuarios = DB::select(
                            "SELECT id_usuario, tx_name 
                            FROM v_funcionario
                            WHERE id_lotacao != 4
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

  return view('painel.aval.index',compact(['resumoAval','lotacao','mes','ano','meses']));
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
    
   public function selectColaborador(){
   
   } //public function end 

   public function insertAval($mes,$ano){

     for($i = 1; $i < 11; $i++){
          $aval = new Aval;
          $aval->id_f1 = Auth::user()->id_usuario;
          $aval->id_f2 = 0;
          $aval->nb_mes = $mes;
          $aval->nb_ano = $ano;
          $aval->nb_idx = $i;
          $aval->save();
     }

   }
   
   public function copyAval($mesant,$anoant){

    $table = DB::table('aval')
           ->select('id_f2','nb_proativ','nb_produtiv','nb_pontual','nb_idx')
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
            $aval = new Aval;
            $aval->id_f1 = Auth::user()->id_usuario;
            $aval->id_f2 =  $entry->id_f2;
            $aval->nb_mes = $mes;
            $aval->nb_ano = $ano;
            $aval->nb_idx =  $entry->nb_idx;
            $aval->save();
    }

  }//public function end 

    public function situacaoAtual()
    {
        $ano = (int) Date('Y');
        $mes = Date('n');
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
        
       if ($atual == '0'){
         //verifica entradas mes passado
        $passado = Aval::where('id_f1','=',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mesant)
        ->where('nb_ano','=',$anoant)
        ->count();

         if($passado == '0'){
           //cria entradas no banco 
           insertAval($mes,$ano);
           return 0;
         }
          //copia mes passado
           copyAval($mesant,$anoant);

           return  DB::table('aval')
           ->select('id_f2','nb_proativ','nb_produtiv','nb_pontual','nb_idx')
           ->where('id_f1','=',Auth::user()->id_usuario)
           ->where('nb_mes','=',$mes)
           ->where('nb_ano','=',$ano)
           ->get();

        }
        else{  
       // return 'avalok';
       return  DB::table('aval')
        ->select('id_f2','nb_proativ','nb_produtiv','nb_pontual','nb_idx')
        ->where('id_f1','=',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();


        } //end else
   
    }  //public function end
  //class end  
}
