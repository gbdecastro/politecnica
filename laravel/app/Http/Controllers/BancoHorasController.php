<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BancoHorasController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return DB::table('dias_uteis')->get();
    }
    
    //dias_uteis
    public function dias_uteis($mes,$ano)
    {
        $resultA = DB::table('dias_uteis')
        ->select(DB::raw('(nb_dias*8) as nb_dias'))
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

        return ($resultA[0]->nb_dias);
    }

    public function mudar_dias_uteis(Request $request)
    {
        $ano = Date('Y');

        DB::table('dias_uteis')
        ->where('nb_mes', $request->input('nb_mes'))
        ->where('nb_ano', $ano)
        ->update([
            'nb_dias' => $request->input('nb_dias'),                                  
        ]);                

    }

    public function mudarBancoHoras(Request $request)
    {
        DB::table('banco_horas')
        ->where('id_funcionario', $request->input('id_funcionario'))
        ->where('nb_mes', $request->input('nb_mes1'))
        ->where('nb_ano', $request->input('nb_ano1'))
        ->update(['nb_saldo' => $request->input('nb_saldo1')]);

        DB::table('banco_horas')
        ->where('id_funcionario', $request->input('id_funcionario'))
        ->where('nb_mes', $request->input('nb_mes2'))
        ->where('nb_ano', $request->input('nb_ano2'))
        ->update(['nb_saldo' => $request->input('nb_saldo2')]);

        DB::table('banco_horas')
        ->where('id_funcionario', $request->input('id_funcionario'))
        ->where('nb_mes', $request->input('nb_mes3'))
        ->where('nb_ano', $request->input('nb_ano3'))
        ->update(['nb_saldo' => $request->input('nb_saldo3')]);
    }
}
