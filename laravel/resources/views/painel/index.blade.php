@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
  <h1><i class="fa fa-dashboard"></i> Painel</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Painel</a></li>
  </ol>     
@endsection

@section('content')

	<!-- ROW COM QUANTIDADE DE GRUPOS, PROJETOS E FUNCIONÁRIOS -->
    <div class="row">
    	<div class="col-md-4">
			<a href="grupos">
				<div class="info-box">
					<span class="info-box-icon bg-red">
						<i class="fa fa-tags"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Grupos</span>
						<span class="info-box-number">{{ $countGrupos }}</span>
					</div>
				</div>
			</a>
    	</div>
    	<div class="col-md-4">
			<a href="projetos">
				<div class="info-box">
					<span class="info-box-icon bg-light-blue">
						<i class="fa fa-object-group"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Projetos</span>
						<span class="info-box-number">{{ $countProjetos }}</span>
					</div>
				</div>
			</a>    		
    	</div>
    	<div class="col-md-4">
			<a href="funcionarios">		
				<div class="info-box">
					<span class="info-box-icon bg-poli">
						<i class="fa fa-users"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Colaboradores</span>
						<span class="info-box-number">{{ $countFuncionarios }}</span>
					</div>
				</div>
			</a>       		
    	</div>    	
    </div>

    <div class="row">
    	<!-- BOX DE ULTIMAS HORAS TRABALHADAS -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro Geral de Horas Trabalhadas
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
    					<table class="table no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>
    								<th>Últimos 3 Meses</th>
									<th>Mês Anterior</th>
									<th>Mês Atual</th>
    							</tr>
    						</thead>
    						<tbody>
    							@foreach($vMediaHorasFuncionarios as $vMediaHorasFuncionarios)
    							<tr>
    								<td>{{ $vMediaHorasFuncionarios->tx_name }}</td>
    								<td>{{ $vMediaHorasFuncionarios->meses }}</td>
									<td>{{ $vMediaHorasFuncionarios->anterior }}</td>
									<td>{{ $vMediaHorasFuncionarios->atual }}</td>
    							</tr>    							
    							@endforeach
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    	{{-- <div class="col-md-5">
    		<!-- BOX DE GASTOS POR FUNCIONÁRIOS -->
			<div class="box box-danger">
				<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Maiores Gastos com Colaboradores
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
		    		@foreach($funcionariosGastos as $funcionariosGastos)
		    		<div class="info-box bg-red">
		    			<span class="info-box-icon">
		    				<i class="fa fa-user"></i>
		    			</span>
		    			<div class="info-box-content">
		    				<span class="info-box-text">{{ $funcionariosGastos->tx_name }}</span>
		    				<span class="info-box-number">R$ {{ number_format($funcionariosGastos->nb_gasto, 2) }}</span>
		    			</div>
		    		</div>
		    		@endforeach					
				</div>
			</div>

			<!-- BOX DE GASTOS POR PROJETOS -->
			<div class="box box-danger">
				<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Maiores Gastos com Projetos
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
		    		@foreach($projetosGastos as $projetosGastos)
		    		<div class="info-box bg-red">
		    			<span class="info-box-icon">
		    				<i class="fa fa-object-group"></i>
		    			</span>
		    			<div class="info-box-content">
		    				<span class="info-box-text">{{ $projetosGastos->tx_projeto }}</span>
		    				<span class="info-box-number">R$ {{ number_format($projetosGastos->nb_gasto, 2) }}</span>
		    			</div>
		    		</div>
		    		@endforeach					
				</div>
			</div>			
    	</div> --}}
    </div>
@endsection