@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
  <h1><i class="fa fa-vcard-o"></i> Perfil</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-vcard-o"></i> Perfil</a></li>
  </ol>     
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-poli">
            <div class="box-body box-profile">
                <input type="file" name="file_profile_image" id="file_profile_image">
                
                <img class="foto_perfil profile-user-img img-responsive img-circle" onerror="this.src='{{ asset('img/user.png')}}'" src="{{ asset('img/user/') }}/{{ hash('sha256',Auth::user()->id_usuario) }}.png" alt="{{ ucwords(strtolower(Auth::user()->tx_name)) }}">

                <h3 class="profile-username text-center">{{ ucwords(strtolower(Auth::user()->tx_name)) }}</h3>
                
                <p class="text-muted text-center">{{ ucwords(strtolower(Auth::user()->tx_funcao)) }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>E-mail</b> <a class="pull-right">{{ Auth::user()->tx_email }}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Data de Admissão</b> <a class="pull-right">{{ date_format(date_create_from_format("Y-m-d",Auth::user()->dt_admissao),"d/m/Y") }}</a>
                    </li>                   
                    @if(Auth::user()->nb_category_user == 1)
                        <li class="list-group-item">
                                <b>Nota</b> <a class="pull-right">{{ Auth::user()->nb_nota }}</a>
                        </li>                    
                    @endif
                    
                </ul>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#projetos" data-toggle="tab">Relação Geral de Projetos</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="projetos">
                    <!-- @if(Auth::user()->nb_category_user == 1)
                        <button type="button" v-on:click.prevent="getProjetosNotFuncionario()" class="btn btn-poli" data-toggle="modal" data-target="#modal_add_projeto">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Projeto
                        </button>
                    @endif -->
                    <!-- <hr> -->
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">100% Complete</span>
                      </div>
                    </div> 
                    <div class="bs-callout bs-callout-danger" id="show_projetos_callout">
                        <h4>Não Possui Nenhum Projeto</h4>
                    </div>                      
                    <div class="table-responsive">                                                
                        <table id="table_projetos" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Empresa</th>
                                    <th>Nome</th>
                                    <th>Grupo</th>
                                    <th>Horas Trabalhadas</th>
                                    <!-- @if(Auth::user()->nb_category_user == 1)
                                        <th>Situação</th>
                                    @endif -->
                                    <!-- @if(Auth::user()->nb_category_user == 1)
                                        <th>Deletar</th>
                                    @endif                                     -->
                                </tr>
                            </thead>

                            <tbody id="tbl_projeto">
                                <tr v-for="projeto_funcionario in projetos_funcionario">
                                    <td>@{{ projeto_funcionario.id_projeto }}</td>
                                    <td>@{{ projeto_funcionario.tx_empresa }}</td>
                                    <td>@{{ projeto_funcionario.tx_projeto }}</td>
                                    <td>@{{ projeto_funcionario.tx_grupo }}</td>
                                    <td>@{{ projeto_funcionario.nb_horas }}</td>
                                    <!-- @if(Auth::user()->nb_category_user == 1)
                                        <td>

                                            <button v-if="projeto_funcionario.cs_situacao == 1" class="btn btn-warning" v-on:click.prevent="desativarProjetoFuncionario(projeto_funcionario)" title="Desativar Projeto">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </button>

                                            <button v-if="projeto_funcionario.cs_situacao == 0" class="btn btn-success" v-on:click.prevent="ativarProjetoFuncionario(projeto_funcionario)" title="Ativar Projeto">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>                                   
                                        </td>
                                    @endif  -->
                                    <!-- @if(Auth::user()->nb_category_user == 1)          
                                        <td>
                                            <button class="btn btn-danger" v-on:click.prevent="deleteProjetoFuncionario(projeto_funcionario)" title="Retirar Funcionário do Projeto">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>                      
                                        </td>
                                    @endif -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- @if(Auth::user()->nb_category_user == 1)
                        @include('funcionarios.add_projeto')                    
                    @endif -->
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-4">
        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">Alterar Senha</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>            
            <div class="box-body">
                <div class="form-group">
                    <label for="tx_senha" class="obrigatorio">Senha:</label>
                    <input type="password" name="alterar_senha" id="alterar_senha" autocomplete="off" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="btn_alterar_senha" class="btn btn-poli">Alterar Senha</button>
                </div>	                
            </div>
            <div class="box-footer">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
                        Ao Alterar a Senha, deverá set efetuado novamento o login. 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection

@section('js')
<script src="{{ asset('js/perfil.js') }}"></script>
<script src="{{ asset('js/perfil_jquery.js') }}"> </script>
@endsection