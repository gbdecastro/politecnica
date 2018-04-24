<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class EmpresasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getEmpresas(){
        return DB::table('empresas')->get()->toJson();
    }
    
}
