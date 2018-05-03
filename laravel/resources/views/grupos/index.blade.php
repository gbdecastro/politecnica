@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
    <h1>
        <i class="fa fa-tags"></i> 
        Grupos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-tags"></i> Grupos</a></li>
      </ol>    
@endsection

@section('content')
<div class="row" id="grupo">
    <div class="col-md-12">
        <div class="box box-poli">
            <div class="box-body">
                <button type="button" class="btn btn-poli" data-toggle="modal" data-target="#modal_create">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Grupo
                </button>
                <hr>
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </div>                    
                <table id="table_grupos" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Cor</th>
                            <th>Projetos</th>
                            <th>Editar</th>
                            <th>Mudar Situação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="grupo in grupos">
                            <td>@{{ grupo.id_grupo }}</td>
                            <td>@{{ grupo.tx_grupo }}</td>
                            <td :style="{'background-color': grupo.tx_color }"></td>
                            <td>
                                <button class="btn btn-block btn-social btn-default" v-on:click.prevent="getProjetos(grupo.id_grupo)"  data-toggle="modal" data-target="#modal_projetos" title="Projetos">
                                    <i class="fa fa-object-group"></i>Projetos
                                </button>
                            </td>
                            <td>

                                <button class="btn btn-block btn-social btn-info" v-on:click.prevent="editGrupo(grupo)" data-toggle="modal" data-target="#modal_edit" title="Editar Grupo">
                                    <i class="fa fa-edit"></i> Editar Grupo
                                </button>
                            </td>
                            <td>
                                <button v-if="grupo.cs_situacao == '0'" v-on:click.prevent="mudarSituacao(grupo)" class="btn btn-block btn-social btn-poli btn-situacao">
                                    <i class="fa fa-eye"></i> Ativar
                                </button>
                                <button v-if="grupo.cs_situacao == '1'" v-on:click.prevent="mudarSituacao(grupo)" class="btn btn-block btn-social btn-danger btn-situacao">
                                    <i class="fa fa-eye"></i> Desativar
                                </button>                                                                                         
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('grupos.create')
    @include('grupos.edit')
    @include('grupos.show_projetos')    
</div>
@endsection

@section('js')
<script src="{{ asset('js/grupos.js') }}"></script>
<script type="text/javascript">
    //validacao do formulario create_grupo
    $('#create_grupo').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tx_grupo: {
                message: 'Nome do Grupo Inválido',
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    }
                }
            },
            new_grupo_color: {     
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    }
                }
            }
        }
    }).on('error.field.bv', function(e, data) {
        data.bv.disableSubmitButtons(true);
    }).on('success.field.bv', function(e, data) {
        data.bv.disableSubmitButtons(false);
    });
    //validacao do formulario edit_grupo
    $('#edit_grupo').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            tx_grupo: {
                message: 'Nome do Grupo Inválido',
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
                    }
                }
            },
            new_grupo_color: {     
                validators: {
                    notEmpty: {
                        message: 'Campo Obrigatório'
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