@extends('adminlte::page')

@section('title', 'Contábil - Grupos')

@section('content_header')
  <h1>
    <i class="fa fa-tags"></i>Grupos
    <small>Painel > Resumo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Painel</a></li>
    <li><a href="#"><i class="fa fa-money"></i>Resumo</a></li>
    <li class="active"><i class="fa fa-tags"></i>Grupos</li>
  </ol>   
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Despesas por Grupos
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
              <div class="chart">
                <canvas id="despesas_grupo" style="height:250px"></canvas>
              </div>  
            </div>
            <div class="overlay">
              <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>      
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Horas Trabalhadas por Grupos
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
              <div class="chart">
                <canvas id="horas_grupos" style="height:250px"></canvas>
              </div>  
            </div>
            <div class="overlay">
              <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>              
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/resumo_grupos.js') }}"></script>
@endsection