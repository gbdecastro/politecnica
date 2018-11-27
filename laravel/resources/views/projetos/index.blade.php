@extends('adminlte::page')

@section('title', 'Projetos')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/square/blue.css') }}">
@endsection

@section('content_header')
    <h1>
        <i class="fa fa-object-group"></i>
        Projetos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-object-group"></i> Projetos</a></li>
      </ol>    
@endsection

@section('content')
<div class="row" id="projeto">
    <div class="col-md-12">
        <div class="box box-poli">
            <div class="box-body">
                <button type="button" id="novo_projeto" class="btn btn-poli" data-toggle="modal" data-target="#modal_create">
                     <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Projeto
                </button>
                <hr>
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </div>
                <div class="table-responsive">
                    <table id="table_projetos" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Empresa</th>                                
                                <th>Projeto</th>
                                <th>Status</th>
                                <th>Grupo</th>
                                <th>Criado em</th>
                                <th>Editar</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_projeto">
                            <tr v-for="projeto in projetos">
                                <td>@{{ projeto.id_projeto }}</td>
                                <td>@{{ projeto.tx_empresa }}</td>
                                <td>@{{ projeto.tx_projeto }}</td>
                                <td>
                                    <p v-if="projeto.cs_status == 0">
                                        Contrato
                                    </p> 
                                    <p v-if="projeto.cs_status == 1">
                                        Perene
                                    </p> 
                                    <p v-if="projeto.cs_status == 2">
                                        Particular
                                    </p>                                                                  
                                </td>
                                <td>@{{ projeto.tx_grupo }}</td>
                                <td>@{{ projeto.created_at }}</td>
                                <td>
                                    <button class="btn btn-block btn-social btn-info" v-on:click.prevent="editProjeto(projeto)" data-toggle="modal" data-target="#modal_edit" title="Editar Projeto">
                                        <i class="fa fa-edit"></i> Editar
                                    </button>
                                </td>
                                <td>
                                    <button v-if="projeto.cs_situacao == '0'" v-on:click.prevent="mudarSituacao(projeto)" class="btn btn-block btn-social btn-poli btn-situacao">
                                        <i class="fa fa-eye"></i> Ativar
                                    </button>
                                    <button v-if="projeto.cs_situacao == '1'" v-on:click.prevent="mudarSituacao(projeto)" class="btn btn-block btn-social btn-danger btn-situacao">
                                        <i class="fa fa-eye"></i> Desativar
                                    </button>  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('projetos.create')
    @include('projetos.edit')
</div>
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/projetos.js') }}"></script>
<script src="{{ asset('js/projetos_jquery.js') }}"></script>
<script type="text/javascript">
    //validacao do formulario create_projeto
    $('#create_projeto').bootstrapValidator({
        message: 'This value is not valid',
        live: 'enabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            id_projeto: {
                message: 'Código do Projeto Inválido',
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Somente Números'
                    }
                }
            },
            tx_projeto: {     
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    stringLenght: {
                        min: 6,
                        message: 'Nome do Projeto deve conter 6 caracteres no mínimo'
                    }               
                }
            }
        }
    }).on('error.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(true);
    }).on('success.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
    }); 
    //validacao do formulario edit_projeto
    $('#edit_projeto').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tx_projeto: {     
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    stringLenght: {
                        min: 6,
                        message: 'Nome do Projeto deve conter 6 caracteres no mínimo'
                    }              
                }
            }
        }
    }).on('error.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(true);
    }).on('success.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
    });          
</script>
@endsection