<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupos;
use Illuminate\Support\Facades\DB;

class GruposController extends Controller
{
    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getGrupos(){
		return Grupos::orderBy('id_grupo','DESC')->get()->toJson();
    }

    public function getProjetos($id_grupo){
        return DB::table('projetos')
                 ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
                 ->where('projetos.id_grupo','=',$id_grupo)
                 ->select('projetos.tx_projeto','projetos.id_projeto')
                 ->get();
    }

    public function index(){
    	return view('grupos.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tx_grupo' => 'required|string|min:6',
            'tx_color' => 'required',
        ]);

        Grupos::create([
            'tx_grupo' => $request->input('tx_grupo'),
            'tx_color' => $request->input('tx_color'),
            'created_at' => date('d-m-Y H:i:s')
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Grupos::where('id_grupo',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'tx_grupo' => 'required|string|min:6',
            'tx_color' => 'required',
        ]);
        Grupos::where('id_grupo', $id)->update($request->all());

    }

    /**
     * Retirada a Opção de Excluir conforme reunião com Norberto
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // public function destroy($id)
    // {
    //     Grupos::find($id)->delete();
    // }


    public function mudarSituacao(Request $request){
        
        Grupos::where('id_grupo',$request->input('id_grupo'))
              ->update(['cs_situacao' => $request->input('cs_situacao')]);
    }
}
