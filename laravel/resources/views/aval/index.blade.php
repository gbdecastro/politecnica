@extends('adminlte::page')

@section('title', 'Avaliação Mensal')

@section('content_header')
  <h1><i class="fa fa-fw fa-users"></i> Avaliação Mensal</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-fw fa-users"></i>Avaliação Mensal</a></li>
  </ol>     
@endsection

@section('content')
<div class="row">
    	<!-- BOX DE Avaliação -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro de Avaliação - 
						@switch($mes)
											@case(1)
											Janeiro
											@break
											@case(2)
											Fevereiro
											@break
											@case(3)
											Março
											@break
											@case(4)
											Abril
											@break
											@case(5)
											Maio
											@break
											@case(6)
											Junho
											@break
											@case(7)
											Julho
											@break
											@case(8)
											Agosto
											@break
											@case(9)
											Setembro
											@break
											@case(10)
											Outubro
											@break
											@case(11)
											Novembro
											@break
											@case(12)
											Dezembro
											@break
											@default
											Mês Atual
											@endswitch
										 / {{ $ano }}
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
    					<table id="tableAval" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Colaborador</th>
									<th>Avaliação</th>
                                </tr>
    						</thead>
    						<tbody>
                            <tr>
                            @for ($i = 1; $i <  11; $i++)
                                <td> {{$i}}.
                                    
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-former="{{$i}}"  required>
                                     <option value="0" >Selecionar Colaborador</option>
                                     @include('aval.option') 
								<div>
								</td>
    					
                                <td>Proatividade:
									<div class="form-group">
									<select class="form-control select2-native slc-nb_proativ" data-former="{{$i}}"  required>
                                        <option value="0">Sem Nota</option>  
									 	<option value="4">Ótimo</option>
										<option value="3">Bom</option>
										<option value="2">Regular</option>
										<option value="1">Ruim</option>
								<div>
								</td>
								<td>Produtividade:
									<div class="form-group">
									<select class="form-control select2-native slc-nb_produtiv" data-former="{{$i}}"  required>
                                        <option value="0">Sem Nota</option>  
									 	<option value="4">Ótimo</option>
										<option value="3">Bom</option>
										<option value="2">Regular</option>
										<option value="1">Ruim</option>		 
								<div>
								</td>
								<td>Pontualidade:
									<div class="form-group">
									<select class="form-control select2-native slc-nb_pontual" data-former="{{$i}}"  required>
                                        <option value="0">Sem Nota</option>  
									 	<option value="4">Ótimo</option>
										<option value="3">Bom</option>
										<option value="2">Regular</option>
										<option value="1">Ruim</option>		 
								<div>
								</td>
							</tr>	 
							@endfor
    						</tbody>
    					</table>
    				
    			</div>
    		</div>
    	</div>
    </div>
<!-- /.row -->
@endsection

@section('js')
<script src="{{ asset('js/aval.js') }}"></script>

@endsection