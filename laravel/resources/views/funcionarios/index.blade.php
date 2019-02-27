@extends('adminlte::page') 
@section('title', 'Funcionários') 
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar_bootstrap.css') }}">    
@endsection 
@section('content_header')
<h1>
    <i class="fa fa-object-group"></i>
    Colaboradores
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-object-group"></i> Colaboradores</a>
    </li>
</ol>
@endsection 
@section('content')
<div class="row" id="funcionario">
    <div class="col-md-12">
        <div class="box box-poli">
            <div class="panel-body">
                <button type="button" class="btn btn-poli" data-toggle="modal" data-target="#modal_create">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Colaborador
                </button>
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="table_funcionarios" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
								<th>Lotação</th>
                                <th>E-mail</th>
                                <th>Contrato</th>
                                <th>Função</th>
                                <th>Telefone</th>
                                <th>Categoria</th>
								<th>Data de Admissão</th>
                                <th>Editar</th>
                                <th>Calendário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(funcionario,key) in funcionarios">
                                <td>@{{ funcionario.tx_name }}</td>
								<td>@{{ funcionario.tx_lotacao }}</td>
                                <td>@{{ funcionario.tx_email }}</td>
                                <td>@{{ funcionario.tx_contrato }}</td>
                                <td>@{{ funcionario.tx_funcao }}</td>
								<td>@{{ funcionario.tx_telefone }}</td>
                                <td>@{{ funcionario.nb_category_user }}</td>
								<td>@{{ funcionario.dt_admissao }}</td>
                                <td>
                                    <button class="btn btn-block btn-social btn-info" data-toggle="modal" data-target="#modal_edit" v-on:click.prevent="editFuncionario(funcionario)">
                                        <i class="fa fa-edit"></i> Editar
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-default" data-toggle="modal" v-bind:data-id_funcionario="funcionario.id_usuario" data-target="#modal_calendario">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('funcionarios.show_projetos') @include('funcionarios.register') @include('funcionarios.edit') @include('funcionarios.add_projeto')
        @include('funcionarios.calendario')
    </div>
</div>
@endsection @section('js')
<script src="{{ asset('js/funcionarios.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/fullcalendar_lang.js') }}"></script>
<script src="{{ asset('js/calendario-funcionario.js') }}"></script>
{{--
<script type="text/javascript">
    //validacao do formulario create_funcionario
    $('#create_funcionario').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tx_name: {
                message: 'Código do Projeto Inválido',
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    stringLenght: {
                        min: 6,
                        message: 'Nome do Funcionário deve conter 6 caracteres no mínimo'
                    },
                    regexp: {
                        regexp: /^[A-Za-z ]+$/,
                        message: 'Nome Inválido'
                    }
                }
            }
            tx_email: {
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    regexp: {
                        regexp: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))+$/,
                        message: 'E-mail Inválido'
                    }
                }
            },
            dt_admissao: {
                valiadotrs: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    }
                }
            },
            tx_password: {
                valiadotrs: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    stringLenght: {
                        minx: 6,
                        message: 'Mínimo de 6 carecteres'
                    }
                }
            },
            tx_password_confirmation: {
                valiadotrs: {
                    identical: {
                        field: 'tx_password',
                        message: 'Senhas não conferem'
                    }
                }
            },
            nb_nota: {
                validators: {
                    between: {
                        min: 0,
                        max: 10,
                        message: 'Nota de 0 à 10'
                    },
                    regexp: {
                        regexp: /^[+-]?([0-9]*[.])?[0-9]+$/,
                        message: 'Nota Inválida'
                    }
                }
            }
        }
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(true);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });
    //validacao do formulario edit_funcionario
    $('#edit_funcionario').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tx_name: {
                message: 'Código do Projeto Inválido',
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    stringLenght: {
                        min: 6,
                        message: 'Nome do Funcionário deve conter 6 caracteres no mínimo'
                    },
                    regexp: {
                        regexp: /^[A-Za-z ]+$/,
                        message: 'Nome Inválido'
                    }
                }
            },
            tx_email: {
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    },
                    regexp: {
                        regexp: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))+$/,
                        message: 'E-mail Inválido'
                    }
                }
            },
            nb_nota: {
                validators: {
                    between: {
                        min: 0,
                        max: 10,
                        message: 'Nota de 0 à 10'
                    },
                    regexp: {
                        regexp: /^[+-]?([0-9]*[.])?[0-9]+$/,
                        message: 'Nota Inválida'
                    }
                }
            }
        }
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(true);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });
</script> 

--}} @endsection