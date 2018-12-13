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

//ROTAS PARA O NOVO RELATÓRIO
//view
Route::get('painel/relatorios','PainelController@relatorioView');
Route::get('painel/relatorio','PainelController@gerarRelatorio');
Route::get('painel/bancohoras','PainelController@bancoHoras');

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