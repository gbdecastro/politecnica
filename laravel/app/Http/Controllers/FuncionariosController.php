<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class FuncionariosController extends Controller
{
    //USO DO CONTROLLER DEFINIDO NAS ROTAS.
    public function getFuncionarios(){
      return DB::table('v_funcionario')
              ->OrderBy('tx_name','ASC')
              ->OrderBy('tx_contrato','ASC')
              ->OrderBy('tx_lotacao','ASC')
              ->get();
    }

    public function index(){
    	return view('funcionarios.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar = $this->validate($request, [
            'tx_name' => 'required|string|max:255',
            'tx_email' => 'required|string|email|max:255|unique:users',
            'dt_admissao' => 'required',
            'tx_password' => 'required|string|min:6|',
            'nb_category_user' => 'required'
        ]);

        if($validar){
          DB::table('users')->insert([
          [
              'tx_name' => $request->input('tx_name'),
              'tx_email' => $request->input('tx_email'),
              'dt_admissao' => $request->input('dt_admissao'),
              'tx_funcao' => $request->input('tx_funcao'),
              'tx_password' => bcrypt($request->input('tx_password')),
			        'cs_tipo_contrato' => $request->input('cs_tipo_contrato'),
              'nb_category_user' => $request->input('nb_category_user'),
              'nb_nota' => $request->input('nb_nota'),
              'nb_custo_hora' => $request->input('nb_custo_hora')
          ]

          ]);
        }else{
          return $validar;
        }
    }

    public function update(Request $request)
    {

        $validar = $this->validate($request, [
            'tx_name' => 'required|string|max:255',
            'tx_email' => 'required|string|email',
            'dt_admissao' => 'required',
            'nb_category_user' => 'required'
        ]);        

        if($validar){
          DB::table('users')
              ->where('id_usuario', $request->input('id_usuario'))
              ->update([
                  'tx_name' => $request->input('tx_name'),
                  'tx_email' => $request->input('tx_email'),
                  'dt_admissao' => $request->input('dt_admissao'),
                  'tx_funcao' => $request->input('tx_funcao'),
				          'cs_tipo_contrato' => $request->input('cs_tipo_contrato'),
                  'nb_category_user' => $request->input('nb_category_user'),
                  'nb_nota' => $request->input('nb_nota'),
                  'nb_custo_hora' => $request->input('nb_custo_hora')                  

          ]);
        }else{
          return $validar;
        }
    }

    public function destroy($id_projeto, $id_grupo, $id_funcionario){
      $error = DB::table('horas_projetos_funcionarios')
        ->where('id_funcionario','=',$id_funcionario)
        ->where('id_projeto','=',$id_projeto)
        ->where('id_grupo','=',$id_grupo)
        ->get()->count();  
      if($error == 0){
        DB::table('projetos_funcionarios')
          ->where('id_funcionario','=',$id_funcionario)
          ->where('id_projeto','=',$id_projeto)
          ->delete();
        }else{
          return "Funcionário Registrou Horas Nesse Projeto";
        }
    }

    public function getProjetosFuncionario($id_funcionario){
        if($id_funcionario==0){
          $id_funcionario = Auth::user()->id_usuario;
        }
        return DB::table('projetos_funcionarios')
                 ->join('projetos','projetos_funcionarios.id_projeto','=','projetos.id_projeto')
                 ->join('grupos','projetos_funcionarios.id_grupo','=','grupos.id_grupo')
                 ->join('empresas','projetos.id_empresa','=','empresas.id_empresa')
                 ->join('horas_projetos_funcionarios', 'projetos_funcionarios.id_projeto', '=', 'horas_projetos_funcionarios.id_projeto')
                 ->where('projetos_funcionarios.id_funcionario','=',$id_funcionario)
                 ->select(
                            'projetos.tx_projeto',
                            'projetos.id_projeto',
                            'grupos.tx_grupo',
                            'grupos.id_grupo',
                            'empresas.tx_empresa',
                            'projetos_funcionarios.id_funcionario',
                            'projetos_funcionarios.cs_situacao',
                            DB::raw('SUM(horas_projetos_funcionarios.nb_horas_trabalho) as nb_horas')
                         )
                 ->groupBy([
                    'projetos.tx_projeto',
                    'projetos.id_projeto',
                    'grupos.tx_grupo',
                    'grupos.id_grupo',
                    'empresas.tx_empresa',
                    'projetos_funcionarios.id_funcionario',
                    'projetos_funcionarios.cs_situacao',                   
                 ])
                 ->orderBy('projetos_funcionarios.created_at','DESC')
                 ->get();
    }

    public function getProjetosNotFuncionario($id_funcionario){
      return  DB::table('projetos')
          ->whereNotIn('id_projeto', function ($query) use ($id_funcionario)
          {
              $query->select('id_projeto')
                    ->from('projetos_funcionarios')
                    ->where('id_funcionario','=',$id_funcionario);
          })
          ->get()->toJson();
    }

    public function desativarProjetoFuncionario(request $request){
      $timestamp = date('Y-m-d G:i:s');
      DB::table('projetos_funcionarios')
        ->where('id_funcionario','=',$request->input('id_funcionario'))
        ->where('id_projeto','=',$request->input('id_projeto'))
        ->where('id_grupo','=',$request->input('id_grupo'))
        ->update(['cs_situacao' => 0]);
    }

    public function ativarProjetoFuncionario(request $request){
      $timestamp = date('Y-m-d G:i:s');
        DB::table('projetos_funcionarios')
          ->where('id_funcionario','=',$request->input('id_funcionario'))
          ->where('id_projeto','=',$request->input('id_projeto'))
          ->where('id_grupo','=',$request->input('id_grupo'))
          ->update(['cs_situacao' => 1]);
    }

    public function adicionarProjetos(request $request){

      $id_grupo = DB::table('projetos')
                    ->where('id_projeto','=',$request->input('id_projeto'))
                    ->first();
      $timestamp = date('Y-m-d G:i:s');
      DB::table('projetos_funcionarios')->insert([
        [
            'id_projeto' => $request->input('id_projeto'),
            'id_funcionario' => $request->input('id_funcionario'),
            'id_grupo' => $id_grupo->id_grupo,
            'cs_situacao' => 1
        ]

        ]);
    }
    
    public function mudarCustoHora(request $request)
    {
      DB::table('users')
      ->where('id_usuario', $request->input('id_usuario'))
      ->update([
          'nb_custo_hora' => $request->input('nb_custo_hora')
      ]);
    }
}
