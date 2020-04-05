@extends('adminlte::page')

@section('title', 'Lotação')

@section('content_header')
<h1>
  	<i class="fa fa-map"></i> Lotação
    <small>Painel > Lotação</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-map"></i> Lotação</a>
    </li>
</ol>    
@endsection

@section('content')

    <div class="row">
    	<!-- BOX DE Lotações -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro de Locais de Trabalho
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>
	    			</div>
    			</div>
    			<div class="box-body">
    				<div class="table-responsive">
    					<table id="tableLotacao" class="table table-striped no-margin">
    						<thead>
    							<tr>
    								<th>Local</th>
									<th>Calendário</th>
                                    <th>Horas Diárias</th>
    							</tr>
    						</thead>
    						<tbody>
    							@foreach($lotacao as $lotacao)
    							<tr>
    								<td>{{ $lotacao->tx_lotacao }}</td>
									<td>
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_edit_diasuteis"
													data-id-lotacao="{{$lotacao->id_lotacao}}"
													data-tx-lotacao="{{$lotacao->tx_lotacao}}"
													data-id-diasuteis="{{$lotacao->id_diasuteis}}">
													<i class="fa fa-edit"></i>
									</button>
									@switch($lotacao->id_diasuteis)
											@case(0)
											São Paulo
											@break
											@case(1)
											Manaus
											@break
											@case(2)
											HDA Manaus
											@break
											@default
											São Paulo
										@endswitch
									</td>
                                    <td>
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_edit_lotacao"
													data-id-lotacao="{{$lotacao->id_lotacao}}"
													data-tx-lotacao="{{$lotacao->tx_lotacao}}"
													data-nb-horas="{{$lotacao->nb_horas}}">
													<i class="fa fa-edit"></i>
										</button>
									<b>{{ $lotacao->nb_horas }}</b>										
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

	<div class="row">
    	<!-- BOX DE Seleção de Dias Uteis SP-->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Dias Úteis Mensais para São Paulo
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button> 				
	    			</div>
    			</div>
    			<div class="box-body">
    				<div class="table-responsive">
    					<table id="tableDiasUteis" class="table no-margin">
    						<tbody>
    							<tr>
    								<td>Janeiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0"  data-mes="01" required>
									 	<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5" >20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div>

									</td>

                                    <td>Fevereiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="02" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5" >19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

                                    <td>Março: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="03" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

                                    <td>Abril: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="04" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              
                                    
									<td>Maio: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="05" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

                                    <td>Junho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0"  data-mes="06" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" >20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>
    							</tr>  

    							<tr>
									<td>Julho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="07" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" selected>20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

									<td>Agosto:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="08" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>                              

									<td>Setembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0"  data-mes="09" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

									<td>Outubro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="10" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

									<td>Novembro:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0"  data-mes="11" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>

									<td>Dezembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="0" data-mes="12" required>
									<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                            
                              
    							</tr>    

    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

	<div class="row">
    	<!-- BOX DE Seleção de Dias Uteis AM-->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Dias Úteis Mensais para Manaus
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button> 				
	    			</div>
    			</div>
    			<div class="box-body">
    				<div class="table-responsive">
    					<table id="tableDiasUteis" class="table no-margin">
    						<tbody>
    							<tr>
    								<td>Janeiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1"  data-mes="01" required>
									 	<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5" >20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div>

									</td>

                                    <td>Fevereiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="02" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5" >19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

                                    <td>Março: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="03" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

                                    <td>Abril: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="04" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              
                                    
									<td>Maio: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="05" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

                                    <td>Junho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1"  data-mes="06" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" >20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>
    							</tr>  

    							<tr>
									<td>Julho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="07" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" selected>20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

									<td>Agosto:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="08" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>                              

									<td>Setembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1"  data-mes="09" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

									<td>Outubro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="10" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

									<td>Novembro:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1"  data-mes="11" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>

									<td>Dezembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="1" data-mes="12" required>
									<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                            
                              
    							</tr>    

    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

	<div class="row">
    	<!-- BOX DE Seleção de Dias Uteis SP-->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Dias Úteis Mensais para Manaus HDA
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button> 				
	    			</div>
    			</div>
    			<div class="box-body">
    				<div class="table-responsive">
    					<table id="tableDiasUteis" class="table no-margin">
    						<tbody>
    							<tr>
    								<td>Janeiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2"  data-mes="01" required>
									 	<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5" >20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div>

									</td>

                                    <td>Fevereiro: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="02" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5" >19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

                                    <td>Março: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="03" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

                                    <td>Abril: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="04" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              
                                    
									<td>Maio: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="05" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" >21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

                                    <td>Junho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2"  data-mes="06" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" >20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>
    							</tr>  

    							<tr>
									<td>Julho: 
									<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="07" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20" selected>20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

									<td>Agosto:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="08" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>                              

									<td>Setembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2"  data-mes="09" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

									<td>Outubro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="10" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              

									<td>Novembro:<div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2"  data-mes="11" required>
										<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div> </td>

									<td>Dezembro: <div class="form-group">
									<select class="form-control select2-native slc-dias-uteis" data-id_diasuteis="2" data-mes="12" required>
									<option value="18">18</option>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                            
                              
    							</tr>    

    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

	@include('painel.lotacao.edit')
@endsection

@section('js')
<script src="{{ asset('js/lotacao.js') }}"></script>
@endsection