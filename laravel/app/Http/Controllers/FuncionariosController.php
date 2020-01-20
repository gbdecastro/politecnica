<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class FuncionariosController extends Controller
{
  //USO DO CONTROLLER DEFINIDO NAS ROTAS.
  public function getFuncionarios()
  {
    return DB::table('v_funcionario')
      ->OrderBy('tx_lotacao','ASC')	
      ->OrderBy('tx_contrato','ASC')		  
            ->OrderBy('tx_name','ASC')
            ->get();
  }

  public function index()
  {
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
            'nb_custo_hora' => $request->input('nb_custo_hora'),
            'id_lotacao' => $request->input('id_lotacao'),
            'tx_telefone' => $request->input('tx_telefone')
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
                'nb_custo_hora' => $request->input('nb_custo_hora'),
                'id_lotacao' => $request->input('id_lotacao'),
                'tx_telefone' => $request->input('tx_telefone')                                    

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

  public function getLotacoes(){
    return DB::table('lotacao')->get()->toJson();
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

  public function getAnos($id_funcionario)
  {
    $min = DB::table('horas_projetos_funcionarios')
                ->where('id_funcionario','=',$id_funcionario)
                ->orderBy('dt_trabalho','ASC')
                ->selectRaw('date_format(dt_trabalho,"%Y") as dt_trabalho')
                ->limit(1)
                ->get();

    $max = DB::table('horas_projetos_funcionarios')
                ->where('id_funcionario','=',$id_funcionario)
                ->orderBy('dt_trabalho','DESC')
                ->selectRaw('date_format(dt_trabalho,"%Y") as dt_trabalho')
                ->limit(1)
                ->get();
    //Caso tenha registros                   
    if(count($min)>0){
      return array($min[0]->dt_trabalho,$max[0]->dt_trabalho);
    }else{
      //caso nao
      return array(Date('Y'),Date('Y'));
    }
  }    

  public function getProjetos($id_funcionario)
  {
      // if($id_funcionario==0){
      //     $id_funcionario = Auth::user()->id_usuario;
      // }
      // $projetos = DB::table('projetos_funcionarios')
      //               ->join('projetos','projetos_funcionarios.id_projeto','=','projetos.id_projeto')
      //               ->where('projetos_funcionarios.id_funcionario','=', $id_funcionario)
      //               ->where('projetos_funcionarios.cs_situacao','=',1)
      //               ->select('projetos.id_projeto','projetos.tx_projeto')
      //               ->get();
      // return $projetos->toJson();
      return DB::table('projetos')->select('id_projeto','tx_projeto')->get()->toJson();
  }

  public function getHorasTrabalhadas($ano,$mes,$projeto,$id_funcionario)
  {
    //todos os projetos
    if($projeto == 0){
      $horas = DB::table('horas_projetos_funcionarios')
      ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
      ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
      ->where('horas_projetos_funcionarios.dt_trabalho','like',$ano.'-'.$mes.'%')
      ->where('horas_projetos_funcionarios.id_funcionario','=',$id_funcionario)
      ->select('horas_projetos_funcionarios.*','projetos.tx_projeto','grupos.tx_color')
      ->get();
    //algum projeto        
    }else{
        $horas = DB::table('horas_projetos_funcionarios')
        ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
        ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
        ->where('horas_projetos_funcionarios.dt_trabalho','like',$ano.'-'.$mes.'%')
        ->where('horas_projetos_funcionarios.id_funcionario','=',$id_funcionario)
        ->where('horas_projetos_funcionarios.id_projeto','=',$projeto)
        ->select('horas_projetos_funcionarios.*','projetos.tx_projeto','grupos.tx_color')
        ->get();
    }
    return $horas;
  }
  
  public function getResumoMensal($ano,$mes,$projeto,$id_funcionario)
  {
    if($projeto != "0"){
        return DB::table('v_resumo_mensal')
        ->where('id_funcionario','=', $id_funcionario)
        ->where('dt_resumo','like',$mes.'/'.$ano)
        ->where('id_projeto','=',$projeto)
        ->get();
    }else{
        return DB::table('v_resumo_mensal')
        ->where('id_funcionario','=', $id_funcionario)
        ->where('dt_resumo','like',$mes.'/'.$ano)
        ->get();            
    }
  }  

  public function getAcumuladoMensal($id_funcionario)
  {
      
      $mes = (int) Date('m');
      $ano = (int) Date('Y');

      $result = DB::table('banco_horas')
      ->select(DB::raw('SUM(nb_saldo) as nb_saldo'))
      ->where('id_funcionario','=',$id_funcionario)
      //->where('nb_ano','=',''.Date('Y').'')
      //->where('nb_mes','=',''.$mes.'')
      ->get();

      if(count($result) > 0)
          $saldoHoras = $result[0]->nb_saldo.' hs';
      else
          $saldoHoras = 'Não Contabilizado';
      if($saldoHoras == null)
        $saldoHoras = 'Não Contabilizado';
      //busca dias
      $resultA = DB::table('dias_uteis')
      ->select(DB::raw('nb_dias'))
      ->where('nb_mes','=',$mes)
      ->where('nb_mes','=',$mes)
      //->where('nb_ano','=',''.Date('Y').'')
      //->where('nb_mes','=',''.$mes.'')
      ->get();
      
      // Get local do usuario para definir a carga de horas
      $resultB = DB::table('users')
      ->select(DB::raw('id_lotacao'))
      ->where('id_usuario','=',$id_funcionario)
      ->get();

      if(($resultB[0]->id_lotacao) == 4)
        $saldoHoras = 'Colaborador Inativo';

      if(($resultB[0]->id_lotacao) == 2)
          $cargaHoras = ($resultA[0]->nb_dias)*9;
      else
          $cargaHoras = ($resultA[0]->nb_dias)*8;

          switch ($mes) {
            case 1:
                $cargaData = 'Janeiro/'.$ano;
            break;      
            case 2:
                $cargaData = 'Fevereiro/'.$ano;
            break; 
            case 3:
                $cargaData = 'Março/'.$ano;
            break; 
            case 4:
                $cargaData = 'Abril/'.$ano;
            break; 
            case 5:
                $cargaData = 'Maio/'.$ano;
            break; 
            case 6:
                $cargaData = 'Junho/'.$ano;
            break; 
            case 7:
                $cargaData = 'Julho/'.$ano;
            break; 
            case 8:
                $cargaData = 'Agosto/'.$ano;
            break; 
            case 9:
                $cargaData = 'Setembro/'.$ano;
            break; 
            case 10:
                $cargaData = 'Outubro/'.$ano;
            break; 
            case 11:
                $cargaData = 'Novembro/'.$ano;
            break; 
            case 12:
                $cargaData = 'Dezembro/'.$ano;
            break; 
            default:
                $cargaData = 'Mês Atual';
            break; 
            } 

      return json_encode([
        'cargaData' => $cargaData,
        'saldoHoras' => $saldoHoras,
        'cargaHoras' => $cargaHoras
      ]);
  }   
}
