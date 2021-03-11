<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

use DB;
use App\User;
use App\Projetos;
use App\Grupos;
use App\XLSXWriter;



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
        //$funcionariosGastos = DB::table('v_funcionarios_gastos')->limit(3)->get();
        //$projetosGastos = DB::table('v_projetos_gastos')->limit(3)->get();
        $vMediaHorasFuncionarios = DB::table('v_media_horas_funcionarios')->get();
        return view('painel.index',compact(['vMediaHorasFuncionarios','countFuncionarios','countProjetos','countGrupos']));
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

    //novo Relatorio
    public function relatorioView(){
        $anomin = $this->carregarAno()[0];
        $anomax = $this->carregarAno()[1];
        return view('painel.relatorios.index',compact('anomin','anomax'));
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

    public function gerarRelatorio(Request $request){
        
        $dt_resumo = $request->input('mes').'/'.$request->input('ano');

        $sheet='Projetos '.$dt_resumo;
        
        $styles1 = array( 'font-size'=>12,'font-style'=>'bold');
        $styles3 = array( [],['halign'=>'right'],[],[]);

        $result0 = DB::table('v_resumo_mensal')->select(DB::raw("tx_color, id_projeto, tx_projeto, SUM(nb_horas) as total_horas, SUM(nb_despesas) as total_despesas"))->where('dt_resumo','like',$dt_resumo)->groupBy(["tx_color", "id_projeto", "tx_projeto"]);

        $n_proj = $result0->count()." Projetos";
        $writer = new XLSXWriter();
		//Write XLS MetaData
		$writer->setTitle('Resumo Mensal dos Projetos');
		$writer->setSubject('Relatorio');
		$writer->setAuthor('SistemaPoliPHT');
		$writer->setCompany('Politecnia Engenharia');
		//Write Cabeçalho
  		$writer->writeSheetHeader($sheet, array('Cod. Projeto' => 'string',
												'Nome' => 'string',
												'Horas' => 'integer',
												'Despesas' => '[$R$-1009] #,##0.00'),
												$col_options = array('widths'=>[10,72,13,20] ));
         $writer->markMergedCell($sheet, $start_row=1, $start_col=0, $end_row=1, $end_col=1);        
		//Linha Principal
		$writer->writeSheetRow($sheet, array('Resumo de Horas e Despesas por Projeto: ('.$n_proj.') - Periodo: '.$dt_resumo), $styles1 );
        $writer->writeSheetRow($sheet, array('','','','')); 
        
        //GERA linha nome do projeto
        foreach ($result0->get() as $row0) {
			$pid = $row0->id_projeto;
			$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> $row0->tx_color);
            $writer->writeSheetRow($sheet, array($row0->id_projeto,$row0->tx_projeto,$row0->total_horas,$row0->total_despesas), $styles2 );
            
            //Preenche os funcionarios relacionados ao projeto
            $result = DB::table('v_resumo_mensal')
                        ->select('nb_horas as horas', 'nb_despesas as despesas', 'tx_name')
                        ->join('users','v_resumo_mensal.id_funcionario','=','users.id_usuario')
                        ->where('v_resumo_mensal.dt_resumo','like',$dt_resumo)
                        ->where('v_resumo_mensal.id_projeto','=',$pid)->get();

            foreach ($result as $row) {

                $writer->writeSheetRow($sheet, array('',$row->tx_name,$row->horas,$row->despesas) ,$styles3 );
            }

        }

        $result = $result0 = '';
		// Gera a pasta dos colaboradores	
		$styles2 = $styles3 = '';
		$sheet2='Colaboradores '.$dt_resumo;
		$writer->writeSheetHeader($sheet2, array('Função' => 'string',
												'Nome' => 'string',
												'Horas' => 'integer',
												'Despesas' => '[$R$-1009] #,##0.00'
												), $col_options = array('widths'=>[18,72,13,20] ));
        $writer->markMergedCell($sheet2, $start_row=1, $start_col=0, $end_row=1, $end_col=1);
        
		//Chamda DB do funcionario
		$result0 = DB::select(DB::raw("SELECT v.id_funcionario, u.tx_funcao, u.tx_name, SUM(v.nb_horas) as total_horas, SUM(v.nb_despesas) as total_despesas FROM v_resumo_mensal v INNER JOIN users u ON v.id_funcionario = u.id_usuario WHERE dt_resumo LIKE '".$dt_resumo."' GROUP BY v.id_funcionario, u.tx_funcao, u.tx_name"));
		//Linha Principal
		$writer->writeSheetRow($sheet2, array('Resumo de Horas e Despesas por Colaborador: 		Periodo: '.$dt_resumo), $styles1 );
        $writer->writeSheetRow($sheet2, array('','','',''));        
        
        $color = 0;

        foreach($result0 as $row0){
            
            $uid = $row0->id_funcionario;
			if(fmod($color,2) == 0){
				$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> '#000000');
				}
				else {
				$styles2 = array( 'font-size'=>11,'font-style'=>'bold', 'color'=> '#555555');
				}
			
            $writer->writeSheetRow($sheet2, array($row0->tx_funcao,$row0->tx_name,$row0->total_horas,$row0->total_despesas), $styles2 );            
            
		    //Preenche os funcionarios relacionados ao projeto
		    $result = DB::select(DB::raw("SELECT v.tx_color, v.id_projeto, v.tx_projeto, v.nb_horas as horas, v.nb_despesas as despesas FROM v_resumo_mensal v WHERE dt_resumo LIKE '".$dt_resumo."' AND v.id_funcionario = ".$uid." ORDER BY v.id_projeto ASC"));
            
            foreach($result as $row){
                $styles3 = array ('color' => $row->tx_color);
                $writer->writeSheetRow($sheet2, array('',$row->id_projeto.' - '.$row->tx_projeto,$row->horas,$row->despesas), $styles3 );
            }
            $color += 1;
        }
        //Query END , create DOCUMENT
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
		$periodo = str_replace('/','-',$dt_resumo);
        $writer->writeToFile($storagePath.'/relatorio_mensal_'.$periodo.'.xlsx');
        
        return response()->download($storagePath.'./relatorio_mensal_'.$periodo.'.xlsx');

    }

    //Banco de Horas
    public function bancoHoras(){

        $mesAtual = Date('m');
        $anoAtual = Date('Y');

        $mesAnterior1 = $mesAtual - 1;
        $mesAnterior2 = $mesAtual - 2;
        $mesAnterior3 = $mesAtual - 3;

        $anoAnterior1 = $anoAtual;
        $anoAnterior2 = $anoAtual;
        $anoAnterior3 = $anoAtual;

        if($mesAnterior1 <=0){
            $mesAnterior1 = 12 + $mesAnterior1;
            $anoAnterior1--;
        }

        if($mesAnterior2 <=0){
            $mesAnterior2 = 12 + $mesAnterior2;
            $anoAnterior2--;
        }
        
        if($mesAnterior3 <=0){
            $mesAnterior3 = 12 + $mesAnterior3;
            $anoAnterior3--;
        }

        $bancoHoras = DB::select(
            "SELECT
                id_usuario,
                u.id_lotacao, 
                l.tx_lotacao,
                l.nb_horas,
                tx_name,
                IFNULL((SELECT nb_saldo FROM banco_horas WHERE id_funcionario = u.id_usuario AND nb_mes = :v_mes1 AND nb_ano = :v_ano1),0) AS mes1,
                IFNULL((SELECT nb_saldo FROM banco_horas WHERE id_funcionario = u.id_usuario AND nb_mes = :v_mes2 AND nb_ano = :v_ano2),0) AS mes2,
                IFNULL((SELECT nb_saldo FROM banco_horas WHERE id_funcionario = u.id_usuario AND nb_mes = :v_mes3 AND nb_ano = :v_ano3),0) AS mes3,
                IFNULL((SELECT SUM(nb_saldo) FROM banco_horas WHERE id_funcionario = u.id_usuario GROUP BY id_funcionario),0) AS mes_atual
             FROM users u 
             INNER JOIN lotacao l ON u.id_lotacao = l.id_lotacao
             WHERE u.cs_tipo_contrato IN (0,2,3,4)
			 ORDER BY u.id_lotacao
             ",
             [
                'v_mes1' => (int) $mesAnterior1,
                'v_mes2' => (int) $mesAnterior2,
                'v_mes3' => (int) $mesAnterior3,
                
                'v_ano1' => (int) $anoAnterior1,
                'v_ano2' => (int) $anoAnterior2,
                'v_ano3' => (int) $anoAnterior3,
                
             ]
        );       
        
        $lotacao = DB::select(
            "SELECT * 
            FROM lotacao
            ORDER BY id_lotacao ASC"
        );

        return view('painel.bancohoras.index',compact(['mesAnterior1','mesAnterior2','mesAnterior3','anoAnterior1','anoAnterior2','anoAnterior3','bancoHoras','lotacao']));
    }
//Resumo Avaliacao
public function resumoAval(){

    $resumoAval = DB::select(
        "SELECT * 
          FROM v_user_aval
          ORDER BY tx_name ASC"
    );

    $lotacao = DB::select(
        "SELECT * 
          FROM lotacao
          ORDER BY id_lotacao ASC"
    );
    
    $ano = (int) Date('Y');
    $mes = Date('n');

    $meses = array("1"=>"Janeiro",
                              "2"=>"Fevereiro",
                              "3"=>"Março",
                              "4"=>"Abril",
                              "5"=>"Maio",
                              "6"=>"Junho",
                              "7"=>"Julho",
                              "8"=>"Agosto",
                              "9"=>"Setembro",
                              "10"=>"Outubro",
                              "11"=>"Novembro",
                              "12"=>"Dezembro"
);

    return view('painel.aval.index',compact(['resumoAval','lotacao','mes','ano','meses']));
}



//Lotacao
public function lotacao(){
    
    $lotacao = DB::select(
        "SELECT * 
        FROM lotacao
        ORDER BY id_lotacao ASC"
    );

    return view('painel.lotacao.index',compact(['lotacao']));
    }

}