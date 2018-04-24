<?php

namespace App\Http\Controllers;

use App\Projetos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class ProjetosController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('admin');
    }

    //função para retornar ao VUE
    public function getProjetos(){
        $projetos =  DB::table('projetos')
         ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
         ->join('empresas','projetos.id_empresa','=','empresas.id_empresa')
         ->selectRaw('projetos.*, empresas.*, grupos.tx_grupo, grupos.tx_color')
         ->orderBy('projetos.tx_projeto','ASC')
         ->get();

        for($i=0;$i<count($projetos);$i++){
            $date = new DateTime($projetos[$i]->created_at);
            $projetos[$i]->created_at = $date->format('d/m/Y');
        }

        return $projetos;
    }

    public function getGrupos(){
        return DB::table('grupos')->get()->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projetos.index');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tx_projeto' => 'required|string|min:3',
            'id_projeto' => 'required',
            'id_grupo' => 'required',
            'id_empresa' => 'required',
        ]);

        $id_empresa = $request->input('id_empresa');

        /*NAO É NUMERO E MARCADO PRA CRIAR UMA NOVA EMPRESA*/
        if(!is_numeric($id_empresa) && $request->input('new_empresa')){

            $id_empresa = strtoupper($id_empresa);

            DB::table('empresas')
              ->insert([
                [
                    'tx_empresa' => $id_empresa
                ]
              ]);

            $d = DB::table('empresas')->where('tx_empresa','=',$id_empresa)->first();

            $id_empresa = $d->id_empresa;

        //SENAO FOR SÓ NUMERO
        }else if(!is_numeric($id_empresa)){
            return "Marque o campo Nova Empresa";
        }else if($request->input('new_empresa')){
            return "Empresa existente, desmarque o campo Nova Empresa";
        }        

        DB::table('projetos')->insert([
        [
            'tx_projeto' => $request->input('tx_projeto'),
            'id_projeto' => $request->input('id_projeto'),
            'id_grupo' => $request->input('id_grupo'),
            'id_empresa' => $id_empresa,
            'cs_status'  => $request->input('cs_status'),            
            'created_at' => date('Y-m-d H:i:s')
        ]

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projetos  $projetos
     * @return \Illuminate\Http\Response
     */
    public function show(Projetos $projetos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projetos  $projetos
     * @return \Illuminate\Http\Response
     */
    public function edit(Projetos $projetos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projetos  $projetos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'tx_projeto' => 'required|string|min:3',
            'id_empresa' => 'required',
        ]);


        $id_empresa = $request->input('id_empresa');
        /*NAO É NUMERO E MARCADO PRA CRIAR UMA NOVA EMPRESA*/
        if(!is_numeric($id_empresa) && $request->input('new_empresa')){

            $id_empresa = strtoupper($id_empresa);

            DB::table('empresas')
              ->insert([
                [
                    'tx_empresa' => $id_empresa
                ]
              ]);

            $d = DB::table('empresas')->where('tx_empresa','=',$id_empresa)->first();

            $id_empresa = $d->id_empresa;

        //SENAO FOR SÓ NUMERO
        }else if(!is_numeric($id_empresa)){
            return "Marque o campo Nova Empresa";
        }else if($request->input('new_empresa')){
            return "Empresa existente, desmarque o campo Nova Empresa";
        }

        DB::table('projetos')
            ->where('id_projeto', $request->input('id_projeto'))
            ->where('id_grupo', $request->input('id_grupo'))
            ->update([
                'tx_projeto' => $request->input('tx_projeto'),
                'id_empresa' => $id_empresa,
                'cs_status'  => $request->input('cs_status'),
                'updated_at' => date('Y-m-d H:i:s')

        ]);
        
    }

    //Desativado conforme reunião com Norberto - Ponto 5
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projetos  $projetos
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id_projeto, $id_grupo)
    // {
    //     Projetos::where('id_projeto', '=', $id_projeto)->where('id_grupo','=',$id_grupo)->delete();
    // }

    public function mudarSituacao(Request $request){
        Projetos::where([
                        ['id_projeto', '=', $request->input('id_projeto')],
                        ['id_grupo', '=', $request->input('id_grupo')]
                ])->update([
                    'cs_situacao' => $request->input('cs_situacao'),
                ]);
    }
}
