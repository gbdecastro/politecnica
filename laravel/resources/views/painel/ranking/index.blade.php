@extends('adminlte::page')

@section('title', 'Organograma')

@section('content_header')
<h1>
  	<i class="fa fa-users"></i>Organograma
    <small>Painel > Organograma</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-users"></i> Organograma</a>
    </li>
</ol>
  
@endsection

@section('content')

@foreach($lotacao as $local)
@if($local->id_lotacao != 4)
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
    				<div class="table-responsive">
    					<table id="tableRanking" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>
									<th>Departamento</th>	
									<th>Hierarquia</th>
    							</tr>
    							
    						</thead>
    						<tbody>
								@foreach($resumoRanking as $user)
								@if($user->id_lotacao == $local->id_lotacao)
									
    							<tr>
    								<td>{{ $user->tx_name }}</td>
									<td>
									<div class="form-group">
									<select id="{{$user->id_usuario}}" class="form-control select2-native slc-nb_departamento"  data-id_usuario="{{$user->id_usuario}}" required>
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
								<div>
								</td>
								<td>
									<div class="form-group">
									<select id="{{$user->id_usuario}}" class="form-control select2-native slc-nb_ranking"  data-id_usuario="{{$user->id_usuario}}" required>
                                        <option value="0">Indefinido</option>  
									 	<option value="9">9. Outros 2</option>
									 	<option value="8">8. Outros 1</option>
									 	<option value="7">7. Estagiário</option>
									 	<option value="6">6. Assistente</option>
									 	<option value="5">5. Efetivo</option>
									 	<option value="4">4. Supervisão</option>
										<option value="3">3. Coordenação</option>
										<option value="2">2. Gerência</option>
										<option value="1">1. Direção</option>
								<div>
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
    </div>
@endif
@endforeach
@endsection

@section('js')
<script src="{{ asset('js/ranking.js') }}"></script>
@endsection