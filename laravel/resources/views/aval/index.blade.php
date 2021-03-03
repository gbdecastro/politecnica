@extends('adminlte::page')

@section('title', 'Avaliação Mensal')

@section('content_header')
  <h1><i class="fa fa-vcard-o"></i> Avaliação Mensal</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-vcard-o"></i>Avaliação Mensal</a></li>
  </ol>     
@endsection

@section('content')
<div class="row">
    	<!-- BOX DE Avaliação -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro de Avaliação - {{ $mes }} / {{ $ano }}
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
									<th>Avaliação</th>
									<th>Colaborador</th>
									<th>Avaliação</th>
                                </tr>
    						</thead>
    						<tbody>
                            @foreach($arr as $valor)
                            <tr>
                                 <td> {{ $ valor }}
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-former="{{ $ valor }}"  data-id_f2="01" required>
                                     <option value="0" >Selecionar Colaborador</option>
                                    @foreach($usuarios as $usuarios)
                                    <option value= "{{  $usuarios->id_usuario }}" >{{  $usuarios->tx_name }}</option>
                                    @endforeach
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-former="{{ $ valor }}"  required>
                                        <option value="0" >Sem Nota</option>  
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										 
								<div>
								</td>
							</tr>	 
							@endforeach
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
<!-- /.row -->
@endsection

@section('js')
<script src="{{ asset('js/aval.js') }}"></script>

@endsection