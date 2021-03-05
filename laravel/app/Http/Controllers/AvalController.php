<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function situacaoAtual()
    {
        $ano = (int) Date('Y');
       // $mes = Date('n');
        $mes = Date('n');

        $resultA = DB::table('aval')
        ->select(DB::raw('count(*) as ct'))
        ->where('id_f1',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

        if ($resultA[0]->ct == '0'){
          
          if ($mes == 1){
            $mes = 12;
            $ano = $ano - 1;
          }
          else{
            $mes = $mes - 1;
           }

           $resultB = DB::table('aval')
              ->select(DB::raw('count(*) as ct'))
              ->where('id_f1',Auth::user()->id_usuario)
              ->where('nb_mes','=',$mes)
              ->where('nb_ano','=',$ano)
              ->get();
              if ($resultB[0]->ct == '0')  {
                  return 0;
              }
              
        }
        else{  
        
        return DB::table('aval')
        ->join('users','aval.id_f2','=','users.id_usuario')
        ->select('aval.id_f2','aval.nb_proativ','nb_produtiv','nb_pontual','users.tx_name')
        ->where('id_f1',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

        } //end else
   
    }  //public function end
  //class end  
}
