<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class BancoHorasController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //dias_uteis
    public function dias_uteis($mes,$ano)
    {
        
        $resultB = DB::table('users')
        ->select(DB::raw('id_lotacao'))
        ->where('id_usuario',Auth::user()->id_usuario)
        ->get();

        $resultC = DB::table('lotacao')
        ->select('nb_horas','id_diasuteis')
        ->where('id_lotacao',$resultB[0]->id_lotacao)
        ->get();

        $resultA = DB::table('dias_uteis')
        ->select('nb_dias')
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->where('id_diasuteis',$resultC[0]->id_diasuteis)
        ->get();

        return ($resultA[0]->nb_dias)*($resultC[0]->nb_horas);
        
    }

    public function mudarBancoHoras(Request $request)
    {
        DB::table('banco_horas')
        ->where('id_funcionario', $request->input('id_funcionario'))
        ->where('nb_mes', $request->input('nb_mes1'))
        ->where('nb_ano', $request->input('nb_ano1'))
        ->update(['nb_saldo' => $request->input('nb_saldo1')]);

        // DB::table('banco_horas')
        // ->where('id_funcionario', $request->input('id_funcionario'))
        // ->where('nb_mes', $request->input('nb_mes2'))
        // ->where('nb_ano', $request->input('nb_ano2'))
        // ->update(['nb_saldo' => $request->input('nb_saldo2')]);

        // DB::table('banco_horas')
        // ->where('id_funcionario', $request->input('id_funcionario'))
        // ->where('nb_mes', $request->input('nb_mes3'))
        // ->where('nb_ano', $request->input('nb_ano3'))
        // ->update(['nb_saldo' => $request->input('nb_saldo3')]);
    }
}
