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
        $mes = Date('F');
       
      //  $usuarios = DB::table('v_funcionario')
        //                ->select('id_usuario','tx_name')
          //              ->where('id_lotacao','=!','4')
            //            ->orderBy('tx_name', 'asc')
              //          ->get();        
        $arr = array(1,2,3,4);

        $usuarios = DB::select(
                            "SELECT id_usuario, tx_name 
                            FROM v_funcionario
                            WHERE id_lotacao != 4
                            ORDER BY tx_name ASC"
                        );

        return view('aval.index', compact(['usuarios','ano','mes','arr']));

    }
    
    public function mudaNota()
    {

    }
   
}
