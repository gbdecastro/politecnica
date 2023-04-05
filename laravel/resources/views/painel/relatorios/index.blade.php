@extends('adminlte::page') 

@section('title', 'Relatórios')

@section('content_header')
<h1>
    <i class="fa fa-file-excel-o"></i> Relatórios
    <small>Painel > Relatórios</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
            <i class="fa fa-file-excel-o"></i>Relatórios</a>
    </li>
</ol>
@endsection @section('content')
<!-- First Row -->
<!-- First Row -->
<!-- First Row -->
<div class="row">
    <!-- FirstBox -->
    <!-- FirstBox -->
    <!-- FirstBox -->
    <div class="col-md-5">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório de Status Mensal
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="box-body_form">
                <div class="form-horizontal form_pesquisa">
                    <!-- Meses -->
                    <div class="form-group">
                        <label for="tx_name" class="col-md-5 control-label obrigatorio">Mês:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="dt_mes" name="dt_mes" required autofocus>
                                <option value="01">Janeiro</option>
                                <option value="02">Fevereiro</option>
                                <option value="03">Março</option>
                                <option value="04">Abril</option>
                                <option value="05">Maio</option>
                                <option value="06">Junho</option>
                                <option value="07">Julho</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Anos -->
                    <div class="form-group" id="div_dt_ano">
                        <label for="tx_name" class="col-md-5 control-label obrigatorio">Ano:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="dt_ano" name="dt_ano" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--)  
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_gerar" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Secound Box -->
    <!-- Secound Box -->
    <!-- Secound Box -->
    <div class="col-md-5">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório Anual por Empresa
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="box-body_form">
                <div class="form-horizontal form_pesquisa">
                    <!-- Meses -->
                    <div class="form-group">
                        <label for="empresa" class="col-md-5 control-label obrigatorio">Empresa:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="id_empresa" name="id_empresa" required autofocus>
                            @foreach($empresas as $empresa)  
                                    <option value="{{$empresa->id_empresa}}"> {{$empresa->tx_empresa}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Anos -->
                    <div class="form-group" id="div_dt_ano">
                        <label for="tx_name" class="col-md-5 control-label obrigatorio">Ano:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="data_ano" name="data_ano" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--) 
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_gerar_anual" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Secound Row -->
<!-- Secound Row -->
<!-- Secound Row -->
<div class="row">
<div class="col-md-5">
    <!-- First BOx -->
    <!-- First BOx -->
    <!-- First BOx -->
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório de Custos Totais
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="box-body_form">                                
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_gerar_total" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                       </div>
                    </div>
           </div>
        </div>    
    </div>
    <!-- Secound Box -->
    <!-- Secound Box -->
    <!-- Secound Box -->
    <div class="col-md-5">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório Anual por Projeto
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="box-body_form">
                <div class="form-horizontal form_pesquisa">
                    <!-- Meses -->
                    <div class="form-group">
                        <label for="projeto" class="col-md-5 control-label obrigatorio">Projeto:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="id_projeto" name="id_projeto" required autofocus>
                            @foreach($projetos as $projeto)  
                                    <option value="{{$projeto->id_projeto}}">{{$projeto->id_projeto}} - {{$projeto->tx_projeto}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Anos -->
                    <div class="form-group" id="div_dt_ano">
                        <label for="tx_name" class="col-md-5 control-label obrigatorio">Ano:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="projeto_ano" name="projeto_ano" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--) 
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_gerar_projeto_anual" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Third Line -->
<!-- Third Line -->
<!-- Third Line -->
<div class="row">
    <!-- First BOx -->
    <!-- First BOx -->
    <!-- First BOx -->
    <div class="col-md-5">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório Anual de Banco de Horas
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal form_pesquisa">
                    <!-- Colaborador -->
                    <div class="form-group">
                        <label for="colaborador" class="col-md-5 control-label obrigatorio">Colaborador:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="banco_colaborador" name="banco_colaborador" required autofocus>
                            @foreach($colaboradores as $colaborador)  
                                    <option value="{{$colaborador->id_usuario}}"> {{$colaborador->tx_name}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Anos -->
                    <div class="form-group">
                        <label for="tx_name" class="col-md-5 control-label obrigatorio">Ano:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="banco_ano" name="banco_ano" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--) 
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_gerar_banco_anual" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Secound Box -->
    <!-- Secound Box -->
    <!-- Secound Box -->
    <div class="col-md-5">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Relatório Colaborador por Período
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="box-body_form">
                <div class="form-horizontal form_pesquisa">
                    <!-- Colaborador -->
                    <div class="form-group">
                        <label for="colaborador" class="col-md-5 control-label obrigatorio">Colaborador:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="colaborador" name="colaborador" required autofocus>
                            @foreach($colaboradores as $colaborador)  
                                    <option value="{{$colaborador->id_usuario}}"> {{$colaborador->tx_name}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Empresa -->
                    <div class="form-group">
                        <label for="empresa" class="col-md-5 control-label obrigatorio">Empresa:</label>
                        <div class="col-md-5">
                            <select type="date" class="form-control select2-native" id="empresa" name="empresa" required autofocus>
                            @foreach($empresas as $empresa)  
                                    <option value="{{$empresa->id_empresa}}"> {{$empresa->tx_empresa}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Periodo Init -->
                    <div class="form-group" id="div_dt_ano">
                        <label for="tx_name" class="col-md-2 control-label obrigatorio">Início:</label>
                        <div class="col-md-3">
                            <select type="date" class="form-control select2-native" id="anoin" name="anoin" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--) 
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select type="date" class="form-control select2-native" id="mesin" name="mesin" required autofocus>
                                <option value="01">Janeiro</option>
                                <option value="02">Fevereiro</option>
                                <option value="03">Março</option>
                                <option value="04">Abril</option>
                                <option value="05">Maio</option>
                                <option value="06">Junho</option>
                                <option value="07">Julho</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                    </div>
                    <!-- Periodo End -->
                    <div class="form-group" id="div_dt_ano">
                        <label for="tx_name" class="col-md-2 control-label obrigatorio">Até:</label>
                        <div class="col-md-3">
                            <select type="date" class="form-control select2-native" id="anoout" name="anoout" required autofocus>
                                @for($i=$anomax;$i>=$anomin;$i--) 
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select type="date" class="form-control select2-native" id="mesout" name="mesout" required autofocus>
                                <option value="01">Janeiro</option>
                                <option value="02">Fevereiro</option>
                                <option value="03">Março</option>
                                <option value="04">Abril</option>
                                <option value="05">Maio</option>
                                <option value="06">Junho</option>
                                <option value="07">Julho</option>
                                <option value="08">Agosto</option>
                                <option value="09">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button id="btn_" type="submit" class="btn btn-poli">
                            <i class="fa fa-file-excel-o"></i>  Gerar Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('js/relatorios.js') }}"></script>
@endsection