<div id="modal_projetos" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">Projetos do Colaborador</h4>
            </div>
            <div class="modal-body">                    
                <button type="button" v-on:click.prevent="getProjetosNotFuncionario()" class="btn btn-poli" data-toggle="modal" data-target="#modal_add_projeto">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vincular Projeto
                </button> 
                <hr>
                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                  </div>
                </div> 
                <div class="bs-callout bs-callout-danger" id="show_projetos_callout">
                    <h4>Não Possui Nenhum Projeto</h4>
                </div>                                
                <div class="table-responsive table_show_projetos">                                                
                    <table id="table_projetos" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Empresa</th>
                                <th>Nome</th>
                                <th>Grupo</th>
                                <th>Situação</th>
                                <th>Deletar</th>
                            </tr>
                        </thead>

                        <tbody id="tbl_projeto">
                            <tr v-for="projeto_funcionario in projetos_funcionario">
                                <td>@{{ projeto_funcionario.id_projeto }}</td>
                                <td>@{{ projeto_funcionario.tx_empresa }}</td>
                                <td>@{{ projeto_funcionario.tx_projeto }}</td>
                                <td>@{{ projeto_funcionario.tx_grupo }}</td>
                                <td>

                                    <button v-if="projeto_funcionario.cs_situacao == 1" class="btn btn-block btn-social btn-warning" v-on:click.prevent="desativarProjetoFuncionario(projeto_funcionario)" title="Desativar Projeto">
                                        <i class="fa fa-eye-slash"></i> Desativar
                                    </button>

                                    <button v-if="projeto_funcionario.cs_situacao == 0" class="btn btn-block btn-social btn-success" v-on:click.prevent="ativarProjetoFuncionario(projeto_funcionario)" title="Ativar Projeto">
                                        <i class="fa fa-eye"></i> Ativar
                                    </button>                                   
                                </td>
                                <td>
                                    <button v-if="projeto_funcionario.tx_projeto" class="btn btn-block btn-social btn-danger" v-on:click.prevent="deleteProjetoFuncionario(projeto_funcionario)" title="Retirar Funcionário do Projeto">
                                        <i class="fa fa-unlink"></i> Desvincular
                                    </button>                                     
                                </td>                                
                            </tr>
                        </tbody>
                    </table>
                </div>        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>            
        </div>
    </div>
</div>