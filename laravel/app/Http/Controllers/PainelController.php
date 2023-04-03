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
     * Simple helper to debug to the console
     *
     * @param $data object, array, string $data
     * @param $context string  Optional a description.
     *
     * @return string
     */
    public function debug_to_console($data, $context = 'Debug in Console') {

        // Buffering to solve problems frameworks, like header() in this and not a solid return.
        ob_start();

        $output  = 'console.info(\'' . $context . ':\');';
        $output .= 'console.log(' . json_encode($data) . ');';
        $output  = sprintf('<script>%s</script>', $output);

        echo $output;
    }

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
        $empresas = $this->carregarEmpresas();
        $colaboradores = $this->carregarUsers();
        return view('painel.relatorios.index',compact('anomin','anomax',['empresas'],['colaboradores']));
    }

    //Carrega Dados para o Form de Pesquisa em Painel.
    public function carregarEmpresas(){
        return DB::table('empresas')
        ->select('id_empresa','tx_empresa')
        ->orderBy('tx_empresa','ASC')
        ->get();
    }
    public function carregarUsers(){
        return DB::table('users')
        ->select('id_usuario','tx_name','cs_tipo_contrato')
        ->orderBy('cs_tipo_contrato','ASC')
        ->get();
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
//Relatorio Inicial Resumo Mensal
    public function gerarRelatorioMensal(Request $request){
        
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
		$writer->setAuthor('SistemaPoliPMHT');
		$writer->setCompany('Politecnica Engenharia');
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

//NOVO Relatorio Periodo 01-04-23
public function gerarRelatorioPeriodo(Request $request){

    
    $id_empresa = $request->input('id_empresa');
    $id_usuario = $request->input('colaborador');
    $mesend = $request->input('mes_fim');
    $mesinit = $request->input('mes_inicio');
    $anoend = $request->input('ano_fim');
    $anoinit = $request->input('ano_inicio');

    $anoinit = 2021;
    $id_empresa = 2;

    //Busca nome da empresa
    $result = DB::table('empresas')
    ->select('tx_empresa')
    ->where('id_empresa','=',$id_empresa)
    ->get();

    $empresa = $result[0]->tx_empresa;

    $result = null;
    //Busca nome do colaborador
    $result = DB::table('users')
    ->select('tx_name')
    ->where('id_usuario','=',$id_usuario)
    ->get();

    $name = $result[0]->tx_name;

    $result = null;
    //Pesquisa Central
    $result = DB::select("SELECT id_empresa, id_funcionario, dt_ano, dt_mes, nb_horas, id_projeto
    FROM v_resumo_mensal_empresa 
    WHERE dt_ano BETWEEN ".$anoinit." AND ".$anoend." AND
    id_empresa = ".$id_empresa." AND id_funcionario = ".$id_usuario.";");
    //Pesquisa Projetos
    $result1 = DB::select("SELECT DISTINCT id_projeto, tx_projeto 
    FROM v_resumo_mensal_empresa
    WHERE dt_ano BETWEEN ".$anoinit." AND ".$anoend." AND
    id_empresa = ".$id_empresa." AND id_funcionario = ".$id_usuario."
    ORDER BY id_projeto ASC;");
    $projetos = count($result1);
    

    $meses=array('Ano','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro','Total');
    
    //Create Master Activities Array
    $lines = array();
    if($anoinit != $anoend){
        $count = 0;
        for($i=$anoinit; $i <= $anoend; $i++){
           
            foreach($result1 as $row1){
                $line = array('',0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                $line[14] += $i;
                $line[0] = $row1->tx_projeto;
                $prj1 = $row1->id_projeto;
                
                foreach($result as $row){
                    $ano = $row->dt_ano;
                    $prj = $row->id_projeto;
                    return json_encode($prj);
                    return json_encode($ano);
                    if($prj == $prj1){
                        $line[$row->dt_mes] += $row->nb_horas;
                        $line[13] += $row->nb_horas;
                        return json_encode($line);
                    }

                }
                $lines[$count]=$line;
                $count++;
            }
        }        
    }
    else{
        $count = 0;  
            foreach($result1 as $row1){
                $line = array('',0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                $line[14] += $anoinit;
                $line[1] = $row1->tx_projeto;
                return json_encode($row);
                foreach($result as $row){
                    
                    if($row->id_projeto == $row1->id_projeto){
                        $line[$row->dt_mes] += $row->nb_horas;
                        $line[13] += $row->nb_horas;
                    }
                    
                }
                $lines[$count]=$line;
                $count++;
            }
    }
    return json_encode($lines);
    //Now to write the datasheets
    $sheet='Resumo '.$name;
        
    $styles1 = array( 'font-size'=>12,'font-style'=>'bold','fill'=> '#3e4a01','color'=>'#fff');
    $styles2 = array( 'font-size'=>11,'font-style'=>'regular','fill'=> '#fff');
        
    $writer = new XLSXWriter();
    //Write XLS MetaData
    $writer->setTitle('Resumo Mensal de Horas Trabalhadas');
    $writer->setSubject('Relatorio');
    $writer->setAuthor('SistemaPoliPMHT');
    $writer->setCompany('Politecnica Engenharia');
    //Write Cabeçalho
    $writer->writeSheetHeader($sheet, array('0' => 'string'),          
    $col_options = array('widths'=>[40,10,10,10,10,10,10,10,10,11,10,12,12] ));
    //Titulo Principal
    $writer->writeSheetRow($sheet, array('Colaborado: '.$tx_name,'- Resumo de Horas Mensais de: '.$mesinit.'/'.$anoinit.' à '.$mesend.'/'.$anoend.' - '.$empresa), $styles1 );      
    $writer->markMergedCell($sheet, $start_row=1, $start_col=1, $end_row=1, $end_col=13);           

    $count = 0;
    for($i=$anoinit; $i <= $anoend; $i++){
        $meses[0]=$anoinit;
        $writer->writeSheetRow($sheet, $meses, $styles2);
        for($i=0; i>=$projetos; $i++){
            $writer->writeSheetRowX($sheet, $lines[$count], $styles2);
            $count++;
        }
    } 
    $line = $lines = $styles1 = $styles2 = null;
    $result = $result1 ='';    
    //Function END , create DOCUMENT
    $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $empresa = str_replace(' ','_',$empresa);
    $writer->writeToFile($storagePath.'./relatorio_periodo_'.$tx_name.'_'.$empresa.'.xlsx');
    $writer = null;

    return response()->download($storagePath.'./relatorio_periodo_'.$tx_name.'_'.$empresa.'.xlsx');
}







//NOVO Relatorio Anual 31-03-23
public function gerarRelatorioAnual(Request $request){

    $dt_ano = $request->input('data_ano');
    $id_empresa = $request->input('id_empresa');
    $meses=array('Colaborador','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro','Total');
    
    //Busca nome da empresa
    $result = DB::table('empresas')
    ->select('tx_empresa')
    ->where('id_empresa','=',$id_empresa)
    ->get();

    $empresa = $result[0]->tx_empresa;

    //Pesquisa para gerar coluna de colaboradores
    $result1 = DB::select("SELECT DISTINCT id_funcionario, tx_name 
    FROM `v_resumo_mensal_empresa` 
    INNER JOIN users ON id_funcionario = id_usuario 
    WHERE id_empresa = ".$id_empresa." and dt_ano = ".$dt_ano." 
    ORDER BY tx_name ASC;"); 
    
    //Pesquisa central
    $result0 = DB::select("SELECT id_empresa, id_funcionario, dt_ano, dt_mes, 
    CONCAT(dt_resumo ,'-', id_funcionario) AS id_code, SUM(nb_horas) AS nb_horas 
    FROM v_resumo_mensal_empresa 
    WHERE id_empresa = ".$id_empresa." and dt_ano = ".$dt_ano." 
    GROUP BY id_code;");

    $sheet='Resumo '.$dt_ano;
        
    $styles1 = array( 'font-size'=>12,'font-style'=>'bold','fill'=> '#3e4a01','color'=>'#fff');
    $styles2 = array( 'font-size'=>11,'font-style'=>'regular','fill'=> '#fff');
        
    $writer = new XLSXWriter();
    //Write XLS MetaData
    $writer->setTitle('Resumo Anual de Horas Trabalhadas');
    $writer->setSubject('Relatorio');
    $writer->setAuthor('SistemaPoliPMHT');
    $writer->setCompany('Politecnica Engenharia');
    //Write Cabeçalho
    $writer->writeSheetHeader($sheet, array('0' => 'string'),          
    $col_options = array('widths'=>[35,10,10,10,10,10,10,10,10,11,10,12,12] ));
    //Titulo Principal
    $writer->writeSheetRow($sheet, array('','Resumo de Horas Trabalhadas por Colobarador para: '.$dt_ano.' - '.$empresa), $styles1 );      
    $writer->markMergedCell($sheet, $start_row=1, $start_col=1, $end_row=1, $end_col=13);           
    $writer->writeSheetRow($sheet, $meses, $styles2);
        
        $color = 0;
        
    foreach($result1 as $row1) {
        $id='';
        if(fmod($color,2) == 0){
            $styles2['fill'] = '#eee';
            }
            else {
            $styles2['fill'] = '#fff';
            }
        $line = array('',0,0,0,0,0,0,0,0,0,0,0,0,0);
        
        $id = $row1->id_funcionario;
        foreach($result0 as $row0){
            if($row0->id_funcionario == $id){
                $line[($row0->dt_mes+0)]+=$row0->nb_horas;
                $line[13]+=$row0->nb_horas;
            }
        }
        $line[0] = $row1->tx_name;
            
        $writer->writeSheetRowX($sheet, $line, $styles2);
        
        $color++;
    }

    $line = $styles1 = $styles3 = $styles4 = null;

    $result = $result0 = $result1 ='';    

    //Function END , create DOCUMENT
    $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $empresa = str_replace(' ','_',$empresa);
    $writer->writeToFile($storagePath.'./relatorio_anual_'.$dt_ano.'_'.$empresa.'.xlsx');
    
    $writer = null;

    return response()->download($storagePath.'./relatorio_anual_'.$dt_ano.'_'.$empresa.'.xlsx');
}

//NOVO Relatorio de Totais
public function gerarRelatorioTotal(){
        
    $dt_resumo =Date('m').'/'.Date('Y');
    ////SHEET 1 BEGIN
    $sheet='Total por Projeto';
    
    $style = array('font-size'=>12);
    $styles1 = array( 'font-size'=>12,'font-style'=>'bold');
    $styles3 = array( [],['halign'=>'right'],[],[]);
    $format1 = array('string','string','string','string','string');
  //  $result0 = DB::table('v_horas_detalhadas')
   // ->select(DB::raw("id_projeto,projeto,SUM(hora) AS horas_totais, SUM(despesa) AS despesas_totais, SUM(total) AS soma"))
  //  ->groupBy("id_projeto");
    $result0 = DB::select(
    "SELECT id_projeto, projeto, SUM(hora) AS horas_totais, SUM(despesa) AS despesas_totais, SUM(total) AS soma, color
    FROM v_horas_detalhadas
    GROUP BY id_projeto"
    );
    $writer = new XLSXWriter();
    //Write XLS MetaData
    $writer->setTitle('Total Acumulado dos Projetos');
    $writer->setSubject('Relatorio');
    $writer->setAuthor('SistemaPoliPMHT');
    $writer->setCompany('Politecnica Engenharia');
    //Write Cabeçalho Para Entradas
    $writer->writeSheetHeader($sheet, array('Cod. Projeto' => 'integer',
    'Nome do Projeto' => 'string',
    'Horas Trabalhadas' => 'integer',
    'Despesas' => '[$R$-1009] #,##0.00',
    'Valor Total' => '[$R$-1009] #,##0.00'),
    $col_options = array('widths'=>[12,96,14,20,20] ), array('font-size'=>12));
    //$writer->markMergedCell($sheet, $start_row=1, $start_col=0, $end_row=1, $end_col=1);        
    //Linha Principal
    $writer->writeSheetRow($sheet, array('','Acumulado Total por Projeto em: '.$dt_resumo), $styles1 );
    $writer->writeSheetRowX($sheet, array('Código','Nome do Projeto','Horas','Despesas','Valor Total'), $style,$format1); 
    $count = 3;
    $color = 0;

    //GERA linha nome do projeto
    foreach ($result0 as $row0) {
        
        if(fmod($color,2) == 0){
            $styles2 = array( 'font-size'=>12, 'fill'=> '#ffffff', 'color'=>$row0->color);
            }
            else {
            $styles2 = array( 'font-size'=>12, 'fill'=> '#eeeeee', 'color'=>$row0->color);
            }

        $writer->writeSheetRowX($sheet, array($row0->id_projeto,$row0->projeto,$row0->horas_totais,$row0->despesas_totais,$row0->soma), $styles2 );
        
        $color += 1; 
        $count += 1;    
    }

    $writer->writeSheetRowX($sheet, array('Código','Nome do Projeto','Horas','Despesas','Valor Total'), $style,$format1); 
    
    $formulaE = "=SOMA(E4:E".$count.")";
    $formulaD ="=SOMA(D4:D".$count.")";
    $formulaC = "=SOMA(C4:C".$count.")";

    $writer->writeSheetRowX($sheet, array('','Totais',$formulaC,$formulaD, $formulaE), $styles1,array('string','string','integer','[$R$-1009] #,##0.00','[$R$-1009] #,##0.00')); 

    $result0 = null;
    //SHEET 1 END
    //SHEET 2 BEGIN
    $result0 = DB::select(
        "SELECT cliente, SUM(hora) AS horas_totais, SUM(despesa) AS despesas_totais, SUM(total) AS soma
        FROM v_horas_detalhadas
        GROUP BY id_empresa
        ORDER BY cliente ASC;"
        );

    //Sheet 02 (CLIENTES)
    $sheet='Total por Cliente';
    //Write Cabeçalho Para Entradas
    $writer->writeSheetHeader($sheet, array('Cliente' => 'string',
    'Horas Trabalhadas' => 'integer',
    'Despesas' => '[$R$-1009] #,##0.00',
    'Valor Total' => '[$R$-1009] #,##0.00'),
    $col_options = array('widths'=>[48,20,20,20] ), array('font-size'=>12));
    //Inicia Info das Colunas    
    $writer->writeSheetRowX($sheet, array('Acumulado Total por Cliente em: '.$dt_resumo), $styles1,$format1);
    $writer->writeSheetRowX($sheet, array('Cliente','Horas Trabalhadas','Despesas','Valor Total'), $style,$format1); 
    
    $count = 3;
    $color = 0;

    //GERA linha nome do CLIENTE
    foreach ($result0 as $row0) {
        
        if(fmod($color,2) == 0){
            $styles2 = array( 'font-size'=>12, 'fill'=> '#ffffff', 'color'=>'#404040');
            }
            else {
            $styles2 = array( 'font-size'=>12, 'fill'=> '#eeeeee');
            }

        $writer->writeSheetRowX($sheet, array($row0->cliente,$row0->horas_totais,$row0->despesas_totais,$row0->soma), $styles2 );
        
        $color += 1; 
        $count += 1;    
    }
    //Info Footer
    $writer->writeSheetRowX($sheet, array('Cliente','Horas Trabalhadas','Despesas','Valor Total'), $style,$format1); 
    //Totais
    $formulaB = "=SOMA(B4:B".$count.")";
    $formulaD ="=SOMA(D4:D".$count.")";
    $formulaC = "=SOMA(C4:C".$count.")";

    $writer->writeSheetRowX($sheet, array('Totais',$formulaB,$formulaC, $formulaD), $styles1,array('string','integer','[$R$-1009] #,##0.00','[$R$-1009] #,##0.00')); 
    $result0=null;
    //SHEET 2 END
    //SHEET 3 BEGIN
    $sheet='Total por Grupo';
    
    $result0 = DB::select(
        "SELECT grupo,SUM(hora) AS horas_totais, SUM(despesa) AS despesas_totais, SUM(total) AS soma, color
        FROM v_horas_detalhadas
        GROUP BY id_grupo
        ORDER BY id_grupo ASC;"
        );
    
     //Write Cabeçalho Para Entradas
     $writer->writeSheetHeader($sheet, array('Grupo' => 'string',
     'Horas Trabalhadas' => 'integer',
     'Despesas' => '[$R$-1009] #,##0.00',
     'Valor Total' => '[$R$-1009] #,##0.00'),
     $col_options = array('widths'=>[48,20,20,20] ), array('font-size'=>12));
     //Inicia Info das Colunas    
     $writer->writeSheetRowX($sheet, array('Acumulado Total por Grupo em: '.$dt_resumo), $styles1,$format1);
     $writer->writeSheetRowX($sheet, array('Grupo','Horas Trabalhadas','Despesas','Valor Total'), $style,$format1); 
     
    $count = 3;
    $color = 0;

    //GERA linha nome do GRUPO
    foreach ($result0 as $row0) {
        
        if(fmod($color,2) == 0){
            $styles2 = array( 'font-size'=>12, 'fill'=> '#eeeeee', 'color'=>$row0->color);
            }
            else {
            $styles2 = array( 'font-size'=>12, 'fill'=> '#ffffff', 'color'=>$row0->color);
            }

        $writer->writeSheetRowX($sheet, array($row0->grupo,$row0->horas_totais,$row0->despesas_totais,$row0->soma), $styles2 );
        
        $color += 1; 
        $count += 1;    
    }
     //Info Footer
    
     //Totais
     $formulaB = "=SOMA(B4:B".$count.")";
     $formulaD ="=SOMA(D4:D".$count.")";
     $formulaC = "=SOMA(C4:C".$count.")";
 
     $writer->writeSheetRowX($sheet, array('Totais',$formulaB,$formulaC, $formulaD), $styles1,array('string','integer','[$R$-1009] #,##0.00','[$R$-1009] #,##0.00')); 
     $result0=null;

    //SHEET 3 END
    //SHEET 4 BEGIN
    $sheet='Total por Status';
    
    $result0 = DB::select(
        "SELECT case when status = 0 then 'Contrato' when status = 1 then 'Perene' when status = 2 then 'Particular' else 'Outros' end AS tipo,SUM(hora) AS horas_totais, SUM(despesa) AS despesas_totais, SUM(total) AS soma
        FROM v_horas_detalhadas
        GROUP BY status
        ORDER BY status ASC;"
        );
    
    //Write Cabeçalho Para Entradas
    $writer->writeSheetHeader($sheet, array('Status' => 'string',
    'Horas Trabalhadas' => 'integer',
    'Despesas' => '[$R$-1009] #,##0.00',
    'Valor Total' => '[$R$-1009] #,##0.00'),
    $col_options = array('widths'=>[48,20,20,20] ), array('font-size'=>12));
    //Inicia Info das Colunas    
    $writer->writeSheetRowX($sheet, array('Acumulado Total por Status em: '.$dt_resumo), $styles1,$format1);
    $writer->writeSheetRowX($sheet, array('Status','Horas Trabalhadas','Despesas','Valor Total'), $style,$format1); 
    
   $count = 3;
   $color = 0;

   //GERA linha nome do Contrato
   foreach ($result0 as $row0) {
       
       if(fmod($color,2) == 0){
           $styles2 = array( 'font-size'=>12, 'fill'=> '#eeeeee');
           }
           else {
           $styles2 = array( 'font-size'=>12, 'fill'=> '#ffffff', 'color'=>'#404040');
           }

       $writer->writeSheetRowX($sheet, array($row0->tipo,$row0->horas_totais,$row0->despesas_totais,$row0->soma), $styles2 );
       
       $color += 1; 
       $count += 1;    
   }
    //Info Footer
    
    //Totais
    $formulaB = "=SOMA(B4:B".$count.")";
    $formulaD ="=SOMA(D4:D".$count.")";
    $formulaC = "=SOMA(C4:C".$count.")";

    $writer->writeSheetRowX($sheet, array('Totais',$formulaB,$formulaC, $formulaD), $styles1,array('string','integer','[$R$-1009] #,##0.00','[$R$-1009] #,##0.00')); 
    $result0=null;

    //SHEET 4 END
    $styles2 = $styles3 = '';

    //Query END , create DOCUMENT
    $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $periodo = str_replace('/','-',$dt_resumo);
    $writer->writeToFile($storagePath.'/relatorio_geral_'.$periodo.'.xlsx');
    
    return response()->download($storagePath.'./relatorio_geral_'.$periodo.'.xlsx');

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
             WHERE u.cs_tipo_contrato IN (0,2,3)
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
            ORDER BY tx_lotacao ASC"
        );

        return view('painel.bancohoras.index',compact(['mesAnterior1','mesAnterior2','mesAnterior3','anoAnterior1','anoAnterior2','anoAnterior3','bancoHoras','lotacao']));
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