@extends('adminlte::page')

@section('title', 'Organograma')

@section('content_header')
<h1>
  	<i class="fa fa-sitemap"></i> Organograma
    <small>Painel > Organograma</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-sitemap"></i> Organograma</a>
    </li>
</ol>
  
@endsection

@section('content')


@foreach($lotacao as $local)
@if($local->id_lotacao != 0)


	<div class="row">
    	<!-- BOX DE Organograma da Empresa -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{ $local->tx_lotacao }}
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>	    				 				
	    			</div>
    			</div>
    			<div class="box-body">
				<div class="progress">
                      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">100% Complete</span>
                </div>
				</div>
    				<table id="tableRanking" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th class="col-md-4">Colaborador</th>
									<th class="col-md-3">Hierarquia</th>
									<th class="col-md-5">Departamento</th>	
    							</tr>
    							
    						</thead>
    						<tbody>
								@foreach($resumoRanking as $user)
								@if($user->id_lotacao == $local->id_lotacao)
									
    							<tr>
    								<td>{{ $user->tx_name }}</td>
								<td>
									<div class="form-group">
										<select class="form-control select2-native slc-nb_ranking slc-rkid{{$user->id_usuario}}"  data-id_usuario="{{$user->id_usuario}}">
                                        <option value="0">Indefinido</option>  
									 	<option value="7">7. Estagiários</option>
									 	<option value="6">6. Técnicos Assistentes</option>
									 	<option value="5">5. Técnicos</option>
									 	<option value="4">4. Terceirizados</option>
										<option value="3">3. Supervisão</option>
										<option value="2">2. Gerência e Consultoria</option>
										<option value="1">1. Direção</option>
										</select>
									</div>
								</td>
								<td>
									<div class="form-group">
										<select class="form-control select2-native slc-nb_departamento slc-dpid{{$user->id_usuario}}"  data-id_usuario="{{$user->id_usuario}}">
                                        <option value="0">Sem Departamento</option>  
									 	<option value="9">Projeto, Gerenciamento e Fiscaliz.</option>
									 	<option value="8">Outros</option>
									 	<option value="7">HVAC</option>
									 	<option value="6">Especialidades</option>
									 	<option value="5">Civil</option>
									 	<option value="4">Hidráulica</option>
										<option value="3">Elétrica</option>
										<option value="2">Arquitetura</option>
										<option value="1">Administrativo</option>
										</select>
									</div>
								</td>
    							</tr>    							
								@endif
								@endforeach
    						</tbody>
    					</table>
    			</div>
    		</div>
    	</div>
  </div>  
	
@endif
@endforeach
@endsection

@section('js')
<script src="{{ asset('js/ranking.js') }}"></script>
@endsection