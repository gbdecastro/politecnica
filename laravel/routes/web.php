<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ROTA PRINCIPAL
Route::get('/', function () {
    if(Auth::check()){
		Auth::user()->bancoHoras();
    	if(Auth::user()->nb_category_user == 0)
    		return redirect('painel/calendario');
    	else
    		return redirect('painel/');
    }else{
    	return view('vendor.adminlte.login');
    }
});
Route::get('/logged',function(){
	if(Auth::check()){
		return Auth::user()->id_usuario;
	}
});
//ROTAS DE AUTORIZAÇÃO
Auth::routes();

//ROTAS DE PERFIL
Route::get('/perfil','PerfilController@index');
Route::post('perfil/foto','PerfilController@foto');
Route::post('perfil/alterarSenha','PerfilController@alterarSenha');

//ROTAS DE VIEW DO PAINEL (ADMIN)
Route::get('painel', 'PainelController@index');
Route::get('painel/resumo/grupos', 'PainelController@resumoGrupos');
Route::get('painel/resumo/projetos', 'PainelController@resumoProjetos');

//ROTAS PARA CARREGAR DADOS DO FORM DE PESQUISA NO PAINEL.
Route::get('painel/resumo/projetos/ano','PainelController@carregarAno');
Route::get('painel/resumo/projetos/empresas','PainelController@carregarEmpresas');

//TEORICAMENTE MORREU!
//ROTAS DE GET(DADOS) DO PAINEL (ADMIN)
	//GRUPOS
	Route::get('painel/resumo/despesas_grupos','PainelController@despesas_grupos');
	Route::get('painel/resumo/horas_grupos','PainelController@horas_grupos');
	//PROJETOS
	Route::get('painel/resumo/projetos/despesas_projetos/{ano}/{mes}','PainelController@despesas_projetos');
	Route::get('painel/relatorio/projetos/horas_projetos/{ano}/{mes}','PainelController@horas_projetos');

//ROTAS PARA VIEWS DO PAINEL
//view
Route::get('painel/relatorios','PainelController@relatorioView');
Route::get('painel/relatorio','PainelController@gerarRelatorio');
Route::get('painel/bancohoras','PainelController@bancoHoras');
Route::get('painel/lotacao','PainelController@lotacao');
Route::get('painel/aval','PainelController@resumoAval');


/*ROTAS DE CALENDARIO EM PAINEL*/
/*PARA USAR BASTA TER AUTH*/
Route::get('painel/calendario', 'HorasTrabalhadasController@calendario');
Route::get('painel/calendario/funcionario/{ano}/{mes}/{projeto}','HorasTrabalhadasController@getHorasTrabalhadas');
Route::post('painel/calendario/funcionario','HorasTrabalhadasController@store');
Route::delete('painel/calendario/funcionario','HorasTrabalhadasController@destroy');
Route::put('painel/calendario/funcionario','HorasTrabalhadasController@edit');
Route::get('painel/calendario/projetos','HorasTrabalhadasController@getProjetos');
Route::get('painel/calendario/projetos/ano/trabalhados','HorasTrabalhadasController@getAnos');
Route::get('painel/calendario/resumoMensal/{ano}/{mes}/{projeto}','HorasTrabalhadasController@getResumoMensal');

/*ROTAS DE FUNCIONARIOS*/
Route::get('vue_funcionarios','FuncionariosController@getFuncionarios');
Route::post('funcionarios','FuncionariosController@store');
Route::get('funcionarios','FuncionariosController@index');
Route::put('funcionarios','FuncionariosController@update');
Route::get('lotacoes','FuncionariosController@getLotacoes');
/**
 * ROTAS DO CALENDARIO EM FUNCIONARIOS
 */
Route::get('funcionarios/calendario/projetos/ano/trabalhados/{funcionario}','FuncionariosController@getAnos');
Route::get('funcionarios/calendario/projetos/{funcionario}','FuncionariosController@getProjetos');
Route::get('funcionarios/calendario/{ano}/{mes}/{projeto}/{funcionario}','FuncionariosController@getHorasTrabalhadas');
Route::get('funcionarios/calendario/resumoMensal/{ano}/{mes}/{projeto}/{funcionario}','FuncionariosController@getResumoMensal');
Route::get('funcionarios/calendario/acumuladoMensal/{funcionario}','FuncionariosController@getAcumuladoMensal');


//SOMENTE ADMIN
Route::group(['middleware' => 'admin'], function(){
	Route::put('funcionario/projeto/desativar','FuncionariosController@desativarProjetoFuncionario');
	Route::put('funcionario/projeto/ativar','FuncionariosController@ativarProjetoFuncionario');
	Route::post('funcionario/projeto','FuncionariosController@adicionarProjetos');
	Route::delete('funcionario/projeto/{id_projeto}/{id_grupo}/{id_funcionario}','FuncionariosController@destroy');
	Route::get('funcionario/{id_funcionario}/not/projetos','FuncionariosController@getProjetosNotFuncionario');
	Route::post('funcionario/mudarCustoHora','FuncionariosController@mudarCustoHora');
});

//COMUM A TODOS
Route::get('funcionario/{id_funcionario}/projetos','FuncionariosController@getProjetosFuncionario');

/*ROTAS DE GRUPOS*/
Route::resource('grupos','GruposController',['except' => 'show', 'create', 'edit', 'destroy']);
Route::post('grupos/mudarSituacao','GruposController@mudarSituacao');
Route::get('vue_grupos','GruposController@getGrupos');
Route::get('projeto/grupo/{id_grupo}','GruposController@getProjetos');

/*ROTAS DE PROJETOS*/
Route::resource('projetos','ProjetosController',['except' => 'show', 'create', 'edit', 'destroy']);
Route::delete('projetos/{id_projeto}/{id_grupo}', 'ProjetosController@destroy');
Route::get('vue_projetos','ProjetosController@getProjetos');
Route::get('projeto/{id_projeto}','ProjetosController@getProjeto');
Route::get('projetos/gerarCodigoProjeto/{id_grupo}','ProjetosController@gerarCodigoProjeto');
Route::put('projetos','ProjetosController@update');
Route::post('projetos/mudarSituacao', 'ProjetosController@mudarSituacao');

/*ROTAS DE EMPREASS*/
Route::get('empresas','EmpresasController@getEmpresas');

/**
 * Rotas Banco de Horas
 */

Route::get('banco_horas/dias_uteis/{mes}/{ano}','BancoHorasController@dias_uteis');
Route::post('banco_horas/mudarBancoHoras','BancoHorasController@mudarBancoHoras');
Route::get('painel/funcionarios/calendario/projetos/ano/trabalhados/{funcionario}','FuncionariosController@getAnos');
Route::get('painel/funcionarios/calendario/projetos/{funcionario}','FuncionariosController@getProjetos');
Route::get('painel/funcionarios/calendario/{ano}/{mes}/{projeto}/{funcionario}','FuncionariosController@getHorasTrabalhadas');
Route::get('painel/funcionarios/calendario/resumoMensal/{ano}/{mes}/{projeto}/{funcionario}','FuncionariosController@getResumoMensal');
Route::get('painel/funcionarios/calendario/acumuladoMensal/{funcionario}','FuncionariosController@getAcumuladoMensal');


/**
 * Rotas Lotacao
 */

Route::post('lotacao/mudarHoras','LotacaoController@mudarHoras'); 
Route::post('lotacao/mudarCalendario','LotacaoController@mudarCalendario');
Route::get('lotacao/dias_uteis/{mes}/{ano}','LotacaoController@dias_uteis');
Route::post('lotacao/mudar_dias_uteis','LotacaoController@mudar_dias_uteis');
Route::get('lotacao/dias_uteis','LotacaoController@index');

/**
 * Rotas Avaliacao
 */
Route::get('aval','AvalController@index');
Route::get('aval/situacaoAtual','AvalController@situacaoAtual');
Route::post('aval/mudarNota','AvalController@mudarNota');
Route::post('aval/selectColaborador','AvalController@selectColaborador');
