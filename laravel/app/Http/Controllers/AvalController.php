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

   } //public function end 

    public function situacaoAtual()
    {
        $ano = (int) Date('Y');
       // $mes = Date('n');
        $mes = Date('n');

        $resultA = Aval::where('id_f1',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->count();
      
       if ($resultA == '0'){
        insertAval($mes,$ano);
        }
        else{  
        
        return Aval::select('id_f2','nb_proativ','nb_produtiv','nb_pontual')
        ->where('id_f1',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

        } //end else
   
    }  //public function end
  //class end  
}
