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
    					<table id="tableBancoHoras" class="table no-margin">
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
                                        </td>

                                    
									    <td>{{ $bancoHoras->mes_atual }}</td>
                                    
                                    
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
    	<!-- BOX DE Seleção de Dias Uteis -->
    	<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    				Quadro de Dias Úteis por Mês
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
    					<table id="tableDiasUteis" class="table no-margin">
    						
    						<tbody>
    							
    							<tr>
    								<td>Janeiro: 
									<div class="form-group">
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5" selected>20.5</option>   
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5" selected>19.5</option>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" selected>21</option>   
										<option value="21.5">21.5</option>   
										<option value="22">22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>    

                                    <td>Abril: 
									<div class="form-group">
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21">21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" selected>22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>                              
                                    
									<td>Maio: 
									<div class="form-group">
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
										<option value="18.5">18.5</option>
										<option value="19">19</option>
										<option value="19.5">19.5</option>
										<option value="20">20</option>
										<option value="20.5">20.5</option>   
										<option value="21" selected>21</option>   
										<option value="21.5">21.5</option>   
										<option value="22" >22</option>   
										<option value="22.5">22.5</option>   
										<option value="23">23</option>   
									</select>
									<div></td>

                                    <td>Junho: 
									<div class="form-group">
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
    							</tr>    							
    							<tr>
									<td>Julho: 
									<div class="form-group">
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
									<select class="form-control select2-native" id="edit_dias_jan" name="dias_uteis" required>
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
@endsection

@section('js')
<script>
	$(function(){
		$("#tableBancoHoras").DataTable({
			"order": [],
			"autoWidth": true,
			"oLanguage": {
				"sUrl": "js/datatables_ptbr.json"
			}						
		})
	})
</script>
@endsection