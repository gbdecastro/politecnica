@extends('adminlte::page')

@section('title', 'Resumo Avaliação')

@section('content_header')
<h1>
  	<i class="fa fa-thumbs-up"></i> Resumo Avaliação
    <small>Painel > Resumo Avaliação</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-thumbs-up"></i> Resumo Avaliação</a>
    </li>
</ol>
<h4><i class="fa fa-info"></i>  Observações:</h4>
<h5><i>  1. Os valores em Ótimo, Bom, Regular e Ruim são a quantidade total de notas recebidas.</i></h5>    
<h5><i>  2. Os valores em Produtividade, Proatividade e Pontualidade são médias de todas notas recebidas respectivamente.</i></h5>    
<h5><i>  3. Composição da Média Geral: Produtividade 50%, Proatividade 30% e Pontualidade 20%.</i></h5>
<h5><i>  4. Nota Máxima: 4,0 e Nota Mínima: 1,0.</i></h5>    
@endsection

@section('content')

@foreach($lotacao as $local)

    <div class="row">
    	<!-- BOX DE Quadro Geral de Avaliações -->
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
    					<table id="tableAval" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>
									<th>Resumo</th>	
									<th class="text-success">Ótimo</th>								
									<th >Bom</th>
                                    <th class="text-warning">Regular</th>
                                    <th class="text-danger">Ruim</th>
									<th>Produtividade</th>
									<th>Proatividade</th>
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
											data-tx-name="{{ $user->tx_name }}" 
											data-id-usuario="{{ $user->id_usuario }}"
											data-mes="{{ $mes }}"
											data-ano="{{ $ano }}">
                                        <i class="fa fa-vcard-o"></i>
                                    </button>
                                	</td>
                                    <td class="text-success">{{ $user->nb_otimo }} </td>
                                    <td>{{ $user->nb_bom }} </td>
                                    <td class="text-warning">{{ $user->nb_regular }} </td>
                                    <td class="text-danger">{{ $user->nb_ruim }} </td>
									<td>{{ number_format($user->md_produtiv,2) }} </td>
									<td>{{ number_format($user->md_proativ,2) }} </td>
									<td>{{ number_format($user->md_pontual,2) }} </td>
									<td><b>{{ number_format((($user->md_pontual*2) + ($user->md_produtiv*5) + ($user->md_proativ)*3)/10,2) }}</b></td>
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

@endforeach
	@include('painel.aval.mapa')
@endsection

@section('js')
<script src="{{ asset('js/resumo_aval.js') }}"></script>
@endsection