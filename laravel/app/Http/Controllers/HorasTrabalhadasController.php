<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HorasTrabalhadas;
use Auth;

class HorasTrabalhadasController extends Controller
{

    //Precisa estar logado
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAnos(){
        $min = DB::table('horas_projetos_funcionarios')
                   ->where('id_funcionario','=',Auth::user()->id_usuario)
                   ->orderBy('dt_trabalho','ASC')
                   ->selectRaw('date_format(dt_trabalho,"%Y") as dt_trabalho')
                   ->limit(1)
                   ->get();

        $max = DB::table('horas_projetos_funcionarios')
                   ->where('id_funcionario','=',Auth::user()->id_usuario)
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

    public function getResumoMensal($ano,$mes,$projeto){
        if($projeto != "0"){
            return DB::table('v_resumo_mensal')
            ->where('id_funcionario','=', Auth::user()->id_usuario)
            ->where('dt_resumo','like',$mes.'/'.$ano)
            ->where('id_projeto','=',$projeto)
            ->get();
        }else{
            return DB::table('v_resumo_mensal')
            ->where('id_funcionario','=', Auth::user()->id_usuario)
            ->where('dt_resumo','like',$mes.'/'.$ano)
            ->get();            
        }
    }
        
    //função para retornar todos os projetos dos funcionários
    public function getProjetos(){
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
    
    public function getHorasTrabalhadas($ano,$mes,$projeto){
      //todos os projetos
      if($projeto == 0){
        $horas = DB::table('horas_projetos_funcionarios')
        ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
        ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
        ->where('horas_projetos_funcionarios.dt_trabalho','like',$ano.'-'.$mes.'%')
        ->where('horas_projetos_funcionarios.id_funcionario','=',Auth::user()->id_usuario)
        ->select('horas_projetos_funcionarios.*','projetos.tx_projeto','grupos.tx_color')
        ->get();
      //algum projeto        
      }else{
          $horas = DB::table('horas_projetos_funcionarios')
          ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
          ->join('grupos','projetos.id_grupo','=','grupos.id_grupo')
          ->where('horas_projetos_funcionarios.dt_trabalho','like',$ano.'-'.$mes.'%')
          ->where('horas_projetos_funcionarios.id_funcionario','=',Auth::user()->id_usuario)
          ->where('horas_projetos_funcionarios.id_projeto','=',$projeto)
          ->select('horas_projetos_funcionarios.*','projetos.tx_projeto','grupos.tx_color')
          ->get();
      }
    	return $horas;
    }

    public function store(Request $request){
    	
        /* Passo a passo
        *  pegar o id_grupo do projeto
        *  depois inseri-lo
        */

        $id_grupo = DB::table('projetos')
                      ->select('id_grupo')
                      ->where('id_projeto','=',$request->input('id_projeto'))
                      ->first();

        $id_grupo = $id_grupo->id_grupo;                      

        // Com a Mudança de regra Há uma verificação
        // se o usuário já possui o projeto
        // ou nao
        $p = DB::table('projetos_funcionarios')
                   ->where('id_funcionario','=',Auth::user()->id_usuario)
                   ->where('id_projeto','=',$request->input('id_projeto'))
                   ->where('id_grupo','=',$id_grupo)
                   ->limit(1)
                   ->get();  

        if(count($p) == 0){
            DB::table('projetos_funcionarios')
            ->insert(
                [
                'id_projeto' => $request->input('id_projeto'),
                'id_funcionario' => Auth::user()->id_usuario,
                'id_grupo'  => $id_grupo,
                'cs_situacao' => '1'
                ]
            );
        }
        HorasTrabalhadas::insert([
            'id_grupo' => $id_grupo,
            'id_projeto' => $request->input('id_projeto'),
            'dt_trabalho' => $request->input('dt_trabalho'),
            'id_funcionario' => Auth::user()->id_usuario,
            'nb_horas_trabalho' => $request->input('nb_horas_trabalho'),
            'nb_despesa' => $request->input('nb_despesa'),
            'nb_custo_hora' => Auth::user()->nb_custo_hora
        ]);

        $response = array(
            'status' => 'success',
            'msg' => 'Horas Trabalhadas cadastradas',
        );

        return $response;
    }

    public function destroy(Request $request){
        HorasTrabalhadas::where('id_projeto','=',$request->input('id_projeto'))
                        ->where('id_funcionario','=',Auth::user()->id_usuario)
                        ->where('dt_trabalho','=',$request->input('dt_trabalho'))
                        ->delete();

        $response = array(
            'status' => 'success',
            'msg' => 'Horas Trabalhadas Excluídas',
        );

        return $response;                        
    }

    public function edit(Request $request){

        //pegar o grupo do projeto selecionado.
        $id_grupo = DB::table('projetos')
                      ->select('id_grupo')
                      ->where('id_projeto','=',$request->input('id_projeto'))
                      ->first();

        HorasTrabalhadas::where('id_projeto','=',$request->input('id_projeto'))
                        ->where('id_funcionario','=',Auth::user()->id_usuario)
                        ->where('dt_trabalho','=',$request->input('dt_trabalho'))
                        ->update([

                            'id_grupo' => $id_grupo->id_grupo,
                            'id_projeto' => $request->input('id_projeto'),
                            'dt_trabalho' => $request->input('dt_trabalho'),
                            'nb_horas_trabalho' => $request->input('nb_horas_trabalho'),
                            'nb_despesa' => $request->input('nb_despesa'),
                            'nb_custo_hora' => Auth::user()->nb_custo_hora
                        ]);

        $response = array(
            'status' => 'success',
            'msg' => 'Horas Trabalhadas Editada',
        );

        return $response;                        
    }
    public function calendario()
    {
        //$mes = (int) Date('m');
        //$mes--;
        $result = DB::table('banco_horas')
        ->select(DB::raw('SUM(nb_saldo) as nb_saldo'))
        ->where('id_funcionario','=',Auth::user()->id_usuario)
        //->where('nb_ano','=',''.Date('Y').'')
        //->where('nb_mes','=',''.$mes.'')
        ->get();

        if(count($result) > 0)
            $saldoHoras = $result[0]->nb_saldo;
        else
            $saldoHoras = 'Não Contabilizado';

        return view('calendario.index', compact(['saldoHoras']));
    }    
}
