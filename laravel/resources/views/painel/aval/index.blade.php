@extends('adminlte::page')

@section('title', 'Resumo Avaliação')

@section('content_header')
<h1>
  	<i class="fa fa-users"></i> Resumo Avaliação
    <small>Painel > Resumo Avaliação</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-users"></i> Resumo Avaliação</a>
    </li>
</ol>
  
@endsection

@section('content')

@foreach($lotacao as $local)
@if($local->id_lotacao != 4)
    <div class="row">
    	<!-- BOX DE Quadro Geral de Saldo de Horas -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{ $local->tx_lotacao }} - Quadro de Avaliação
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
									<th>Mapa</th>	
									<th>Ótimo</th>								
									<th>Bom</th>
                                    <th>Regular</th>
                                    <th class="text-danger">Ruim</th>
									<th>Proatividade</th>
									<th>Produtividade</th>
									<th>Pontualidade</th>
									<th>Média Geral</th>
    							</tr>
    							</tr>
    						</thead>
    						<tbody>
								@foreach($resumoAval as $user)
								@if($user->id_lotacao == $local->id_lotacao)
									
    							<tr>
    								<td>{{ $user->tx_name }}</td>
									<td>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal_mapa"
											data-tx_funcionario="{{ $user->tx_name }}" 
											data-id_funcionario="{{ $user->id_usuario }}">
                                        <i class="fa fa-vcard-o"></i>
                                    </button>
                                	</td>
                                    <td>{{ $user->nb_otimo }} </td>
                                    <td>{{ $user->nb_bom }} </td>
                                    <td>{{ $user->nb_regular }} </td>
                                    <td class="text-danger">{{ $user->nb_otimo }} </td>
									<td>{{ $user->md_proativ }} </td>
									<td>{{ $user->md_produtiv }} </td>
									<td>{{ $user->md_pontual }} </td>
									<td>{{ ($user->md_pontual + $user->md_produtiv + $user->md_proativ)/3 }} </td>
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

@endsection