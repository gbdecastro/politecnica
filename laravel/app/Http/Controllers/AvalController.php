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
        
    }
   
    public function situacaoAtual()
    {
        $ano = (int) Date('Y');
        $mes = Date('n');

        return DB::table('aval')
        ->join('users','aval.id_f2','=','users.id_usuario')
        ->select('aval.id_f2','aval.nb_nota','users.tx_name')
        ->where('id_f1',Auth::user()->id_usuario)
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();


    }
}
