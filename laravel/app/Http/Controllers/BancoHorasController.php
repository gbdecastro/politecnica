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
    
    //dias_uteis
    public function dias_uteis($mes,$ano)
    {
        $resultA = DB::table('dias_uteis')
        ->select(DB::raw('nb_dias*8'))
        ->where('nb_mes','=',$mes)
        ->where('nb_ano','=',$ano)
        ->get();

        return ($resultA[0]->nb_dias);
    }
}
