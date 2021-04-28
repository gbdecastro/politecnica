@extends('adminlte::page')

@section('title', 'Banco de Horas')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar_bootstrap.css') }}">    
@endsection 
@section('content_header')
<h1>
  	<i class="fa fa-database"></i> Banco de Horas
    <small>Painel > Banco de Horas</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-database"></i> Banco de Horas</a>
    </li>
</ol>
  
@endsection

@section('content')

@foreach($lotacao as $local)
@if($local->id_lotacao != 0)
    <div class="row">
    	<!-- BOX DE Quadro Geral de Saldo de Horas -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{ $local->tx_lotacao }} - Quadro de Horas	/ Carga Horária : {{ $local->nb_horas}}	Horas	
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>	    				 				
	    			</div>
    			</div>
    			<div class="box-body">
    				<div class="table-responsive">
    					<table id="tableBancoHoras" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>	
									<th>Calendário</th>								
									<th>{{ $mesAnterior3 }}/{{ $anoAnterior3 }}</th>
                                    <th>{{ $mesAnterior2 }}/{{ $anoAnterior2 }}</th>
                                    <th>{{ $mesAnterior1 }}/{{ $anoAnterior1 }}</th>
									<th>Saldo Atual</th>

    							</tr>
    						</thead>
    						<tbody>
								@foreach($bancoHoras as $user)
								@if($user->id_lotacao == $local->id_lotacao)
									
    							<tr>
    								<td>{{ $user->tx_name }}</td>
									<td>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_calendario"
											data-tx_funcionario="{{ $user->tx_name }}" 
											data-id_funcionario="{{ $user->id_usuario }}">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                	</td>
                                    @if($user->mes3 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
                                            {{ $user->mes3 }}
                                        </td>

                                    @if($user->mes2 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
                                            {{ $user->mes2 }}
                                        </td>

                                    @if($user->mes1 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
    								       
											<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_edit_banco_horas"
												data-id-funcionario="{{$user->id_usuario}}"
												data-tx-name="{{$user->tx_name}}"
												data-mes3="{{$user->mes3}}"
												data-mes2="{{$user->mes2}}"
												data-mes1="{{$user->mes1}}"
												data-mes-anterior-3="{{$mesAnterior3}}"
												data-mes-anterior-2="{{$mesAnterior2}}"
												data-mes-anterior-1="{{$mesAnterior1}}"
												data-ano-anterior-3="{{$anoAnterior3}}"
												data-ano-anterior-2="{{$anoAnterior2}}"
												data-ano-anterior-1="{{$anoAnterior1}}">
                                        		<i class="fa fa-edit"></i>
                                    		</button>	
											{{ $user->mes1 }}											
                                        </td>

										@if($user->mes_atual < 0)
									    <td class="text-danger">
                                   		 @else
                                        <td>
                                   		 @endif
									    {{ $user->mes_atual }}</td>
    							</tr>    							
								@endif
								@endforeach
    						</tbody>
    					</table>
					</div>
    			</div>
    		</div>
    	</div>
    </div>
@endif
@endforeach
	@include('painel.bancohoras.calendario')
	@include('painel.bancohoras.edit')
@endsection

@section('js')
<script src="{{ asset('js/banco_horas.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/fullcalendar_lang.js') }}"></script>
<script src="{{ asset('js/calendario-funcionario.js') }}"></script>
@endsection