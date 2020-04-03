<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LotacaoController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ano = (int) Date('Y');

        return DB::table('dias_uteis')
                ->where('nb_ano','=',$ano)
                ->get();
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

    public function mudar_dias_uteis(Request $request)
    {
        $ano = Date('Y');

        DB::table('dias_uteis')
        ->where('nb_mes', $request->input('nb_mes'))
        ->where('nb_ano', $ano)
        ->where('id_diasuteis',$request->input('id_diasuteis'))
        ->update([
            'nb_dias' => $request->input('nb_dias'),                                  
        ]);                

    }

    public function mudarHoras(Request $request)
    {
        DB::table('lotacao')
        ->where('id_lotacao', $request->input('id_lotacao'))
        ->update(['nb_horas' => $request->input('nb_horas')]);

    }

    public function mudarCalendario(Request $request)
    {
        DB::table('lotacao')
        ->where('id_lotacao', $request->input('id_lotacao'))
        ->update(['id_diasuteis' => $request->input('id_diasuteis')]);

    }
}
