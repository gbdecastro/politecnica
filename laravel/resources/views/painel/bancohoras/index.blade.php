@extends('adminlte::page')

@section('title', 'Banco de Horas')

@section('content_header')
  <h1><i class="fa fa-dashboard"></i> Painel</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-database"></i> Banco de Horas</a></li>
  </ol>     
@endsection

@section('content')

    <div class="row">
    	<!-- BOX DE Quadro Geral de Saldo de Horas -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro Geral de Saldo de Horas
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
    				<div class="table-responsive">
    					<table id="tableBancoHoras" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>
									<th>{{ $mesAnterior3 }}/{{ $anoAnterior3 }}</th>
                                    <th>{{ $mesAnterior2 }}/{{ $anoAnterior2 }}</th>
                                    <th>{{ $mesAnterior1 }}/{{ $anoAnterior1 }}</th>
									<th>Saldo Atual</th>
    							</tr>
    						</thead>
    						<tbody>
    							@foreach($bancoHoras as $bancoHoras)
    							<tr>
    								<td>{{ $bancoHoras->tx_name }}</td>

                                    @if($bancoHoras->mes3 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
                                            {{ $bancoHoras->mes3 }}
                                        </td>

                                    @if($bancoHoras->mes2 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
                                            {{ $bancoHoras->mes2 }}
                                        </td>

                                    @if($bancoHoras->mes1 < 0)
									    <td class="text-danger">
                                    @else
                                        <td>
                                    @endif
    								        {{ $bancoHoras->mes1 }}
											<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_edit_banco_horas"
												data-id-funcionario="{{$bancoHoras->id_usuario}}"
												data-tx-name="{{$bancoHoras->tx_name}}"
												data-mes3="{{$bancoHoras->mes3}}"
												data-mes2="{{$bancoHoras->mes2}}"
												data-mes1="{{$bancoHoras->mes1}}"
												data-mes-anterior-3="{{$mesAnterior3}}"
												data-mes-anterior-2="{{$mesAnterior2}}"
												data-mes-anterior-1="{{$mesAnterior1}}"
												data-ano-anterior-3="{{$anoAnterior3}}"
												data-ano-anterior-2="{{$anoAnterior2}}"
												data-ano-anterior-1="{{$anoAnterior1}}">

                                        		<i class="fa fa-edit"></i>
                                    		</button>												
                                        </td>

										@if($bancoHoras->mes_atual < 0)
									    <td class="text-danger">
                                   		 @else
                                        <td>
                                   		 @endif
									    {{ $bancoHoras->mes_atual }}</td>
    							</tr>    							
    							@endforeach
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

	@include('painel.bancohoras.edit')
@endsection

@section('js')
<script src="{{ asset('js/banco_horas.js') }}"></script>
@endsection