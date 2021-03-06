@extends('adminlte::page')

@section('title', 'Calendário')

@section('content_header')
    <h1>
        <i class="fa fa-calendar"></i> Calendário
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-calendar"></i> Calendário</a></li>
      </ol>    
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar_bootstrap.css') }}">
@endsection


@section('content')
<input type="hidden" id="mesBack" value="{{ $mesBack }}">
<input type="hidden" id="anoBack" value="{{ $anoBack }}">
<div class="row">
    <div class="col-md-4">
        
        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Pesquisar Histórico
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                                     
                </div>
            </div>
            <div class="box-body">              
                @include('calendario.form_pesquisa')
                @include('calendario.show_evento')
                @include('calendario.create_evento')
            </div>
        </div>

        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Acumulado Mensal
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                                      
                </div>                
            </div>              
            <div class="box-body">
                @if(Auth::user()->cs_tipo_contrato == 0 or Auth::user()->cs_tipo_contrato == 2 or Auth::user()->cs_tipo_contrato == 3  )
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-info"></i>- Banco de Horas - Saldo: {{ $saldoHoras }}</h4>
                        <h5>Carga Horária Obrigatória para {{ $cargaData }}: <b> {{ $cargaHoras }} </b> hs</h5>
                        <cite>Atenção! Todo o dia primeiro de cada mês é contabilizado o Saldo de Horas.</cite>
                    </div>
                @endif                     
                <div class="info-box bg-yellow" id="corBox">
                    <span class="info-box-icon"><i class="fa fa-object-group"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Horas Acumuladas</span>
                        <span id="horasAcumuladas" class="info-box-number"></span>

                        <div class="progress">
                            <div id="progressoHoras" class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                                
                        </span>
                    </div>
                </div>                             
                <div id="resumo"></div>
            </div>                    
        </div>

    </div>
    <div class="col-md-8">
        <div class="box box-poli">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Calendário de Horas
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-toll" type="button" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                                   
                </div>
            </div>
            <div class="box-body">
                <div id="calendario"></div>
            </div>      
        </div>   
    </div>       
</div>   
@endsection

@section('js')
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/fullcalendar_lang.js') }}"></script>
<script src="{{ asset('js/calendario_horas.js') }}"></script>
@endsection