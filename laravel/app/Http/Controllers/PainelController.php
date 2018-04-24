<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

use DB;
use App\User;
use App\Projetos;
use App\Grupos;

class PainelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countFuncionarios = User::count();
        $countProjetos = Projetos::count();
        $countGrupos = Grupos::count();
        $funcionariosGastos = DB::table('v_funcionarios_gastos')->limit(3)->get();
        $projetosGastos = DB::table('v_projetos_gastos')->limit(3)->get();
        $vMediaHorasFuncionarios = DB::table('v_media_horas_funcionarios')->get();
        return view('painel.index',compact(['vMediaHorasFuncionarios','countFuncionarios','countProjetos','countGrupos','funcionariosGastos','projetosGastos']));
    }

    //Retorno de Views
    public function resumoGrupos()
    {
        return view ('painel.resumo.grupos');

    }

    public function resumoProjetos()
    {
        return view ('painel.resumo.projetos');
    }

    //Carrega Dados para o Form de Pesquisa em Painel.
    public function carregarEmpresas(){
        return DB::table('empresas')->orderBy('tx_empresa','ASC')->get();

    }
    public function carregarAno(){
        $min = DB::table('horas_projetos_funcionarios')
                   ->orderBy('dt_trabalho','ASC')
                   ->selectRaw('date_format(dt_trabalho,"%Y") as dt_trabalho')
                   ->limit(1)
                   ->get();

        $max = DB::table('horas_projetos_funcionarios')
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

    //Charts de Grupos
    public function despesas_grupos(){
        //execute procedure
        DB::select('call sp_despesas_grupos(' . Date('Y') . ')');

        $despesas =  DB::table('despesas_grupos')
                       ->join('grupos','despesas_grupos.id_grupo','=','grupos.id_grupo')
                       ->where('despesas_grupos.dt_despesa','like','%/'.Date('Y').'%')
                       ->select('despesas_grupos.*','grupos.tx_grupo','grupos.tx_color')
                       ->get();
        return $despesas;
    }

    public function horas_grupos(){
        //execute procedure
        DB::select('call sp_horas_grupos(' . Date('Y') . ')');    
            
        return DB::table('horas_grupos')
                 ->join('grupos','horas_grupos.id_grupo','=','grupos.id_grupo')
                 ->where('horas_grupos.dt_horas','like','%/'.Date('Y').'%')
                 ->select('horas_grupos.*','grupos.tx_grupo','grupos.tx_color')
                 ->get();
    }

    //Charts de Projetos
    public function despesas_projetos($ano, $mes){
        $result =  DB::table('horas_projetos_funcionarios')
            ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
            ->join('grupos','horas_projetos_funcionarios.id_grupo','=','grupos.id_grupo')
            ->where('horas_projetos_funcionarios.dt_trabalho','like', $ano.'-'.$mes.'%')
            ->select('projetos.tx_projeto','grupos.tx_color', DB::raw('SUM(horas_projetos_funcionarios.nb_despesa) as nb_despesa'))
            ->groupBy(['horas_projetos_funcionarios.id_projeto','projetos.tx_projeto','grupos.tx_color','horas_projetos_funcionarios.dt_trabalho'])
            ->orderBy('horas_projetos_funcionarios.dt_trabalho','asc')->get();
        $valor = 0;

        for($i=0;$i<count($result);$i++){
            $valor = $valor + $result[$i]->nb_despesa;
        }

        $result[0]->valor_total = $valor;

        return $result;
    }
    public function horas_projetos($ano, $mes){
        $result =  DB::table('horas_projetos_funcionarios')
            ->join('projetos','horas_projetos_funcionarios.id_projeto','=','projetos.id_projeto')
            ->join('grupos','horas_projetos_funcionarios.id_grupo','=','grupos.id_grupo')
            ->where('horas_projetos_funcionarios.dt_trabalho','like', $ano.'-'.$mes.'%')
            ->select('projetos.tx_projeto','grupos.tx_color', DB::raw('SUM(horas_projetos_funcionarios.nb_horas_trabalho) as nb_horas'))
            ->orderBy('horas_projetos_funcionarios.dt_trabalho','asc')
            ->groupBy(['horas_projetos_funcionarios.id_projeto','projetos.tx_projeto','grupos.tx_color','horas_projetos_funcionarios.dt_trabalho'])->get();
        $valor = 0;

        for($i=0;$i<count($result);$i++){
            $valor = $valor + $result[$i]->nb_horas;
        }

        $result[0]->valor_total = $valor;

        return $result;
    }
    public function gerarRelatorio($ano,$mes){
        $horas = DB::table('v_horas_trabalhadas')->where('mes','=',$mes)->where('ano','=',$ano)->get();
        return view('painel.resumo.excel', ['horas' =>$horas]);
    }
}
