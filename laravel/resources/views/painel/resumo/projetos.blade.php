@extends('adminlte::page')

@section('title', 'Contábil - Projetos')

@section('content_header')
  <h1>
    <i class="fa fa-object-group"></i>Projetos
    <small>Painel > Resumo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Painel</a></li>
    <li><a href="#"><i class="fa fa-money"></i>Resumo</a></li>
    <li class="active"><i class="fa fa-object-group"></i>Projetos</li>
  </ol>   
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-poli" id="box_form">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Filtro de Pesquisa
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button class="btn btn-box-toll" type="button" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>                   
                </div>
            </div>
            <div class="box-body" id="box-body_form">
              <div class="form-horizontal form_pesquisa">
                  <!-- Meses -->
                  <div class="form-group">
                      <label for="tx_name" class="col-md-4 control-label obrigatorio">Mês:</label>
                      <div class="col-md-6">
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
                  <!-- Empresas
                  <div class="form-group">
                    <label for="show_evento_projeto" class="col-md-4 control-label obrigatorio">Empresas:</label>
                    <div class="col-md-6">
                      <select type="text" class="form-control select2-native" id="slc_empresas" >

                      </select>
                    </div>
                  </div>                     -->
                  <!-- Anos -->
                  <div class="form-group" id="div_dt_ano">
                      <label for="tx_name" class="col-md-4 control-label obrigatorio">Ano:</label>
                      <div class="col-md-6">
                        <select type="date" class="form-control select2-native" id="dt_ano" name="dt_ano" required autofocus></select>
                      </div>
                  </div>
                  <!-- Submit -->
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button id="btn_gerar" type="submit" class="btn btn-poli">
                            Gerar Relatório
                        </button>
                    </div>
                  </div>
                  </div>                  
              </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-poli" id="box_despesas">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Despesas por Projetos
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-toll" type="button" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button class="btn btn-box-toll" type="button" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>                   
                    </div>
                </div>
                <div class="box-body">    
                    <canvas id="chartDespesas" height="100"></canvas>
                    <h4 id="total_despesa"></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
            <div class="box box-poli" id="box_horas">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Horas Trabalhadas por Projetos
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-toll" type="button" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button class="btn btn-box-toll" type="button" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>                   
                    </div>
                </div>
                <div class="box-body">    
                    <canvas id="chartHoras" height="100"></canvas>
                    <h4 id="total_horas"></h4>
                </div>
            </div>
        </div>                         
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/resumo_projetos.js') }}"></script>
@endsection