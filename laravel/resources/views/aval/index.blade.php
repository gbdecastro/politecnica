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
                                </tr>
    						</thead>
    						<tbody>
                            <tr>
                                 <td>01.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>

                                <td>02.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>
    							</tr> 
                                <tr>
                                 <td>03.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>

                                <td>04.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>
    							</tr>    
                                <tr>
                                 <td>05.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>

                                <td>06.
									<div class="form-group">
									<select class="form-control select2-native slc-colaborador" data-nb_nota="0"  data-id_f2="01" required>
										<option value="3">Vinicius Takahashi</option>
										<option value="2">Shigueto Mori</option>
										<option value="1">Rita Lopes</option>
										<option value="0" >Selecionar Colaborador</option>   
                                   
								<div>
								</td>
    					
                                <td>
									<div class="form-group">
									<select class="form-control select2-native slc-nb_nota" data-nb_nota="0"  required>
									 	<option value="5">Ótimo</option>
										<option value="4">Bom</option>
										<option value="3">Regular</option>
										<option value="2">Fraco</option>
										<option value="1">Ruim</option>
										<option value="0" >Sem Nota</option>   
								<div>
								</td>
    							</tr>    
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