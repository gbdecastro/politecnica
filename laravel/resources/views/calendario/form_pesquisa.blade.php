<div class="form-horizontal form_pesquisa">
    <div class="form-group">
        <label for="tx_name" class="col-md-4 control-label obrigatorio">Mês:</label>
        <div class="col-md-6">
        	<select type="date" class="form-control select2-native" id="dt_mes" name="dt_mes" required autofocus>
        		<option value="01">Janeiro</option>
        		<option value="02">Fevereiro</option>
        		<option value="03">Março</option>
        		<option value="04">Abril</option>
        		<option value="05">Maio</option>
        		<option value="06">Junho</option>
        		<option value="07">Julho</option>
        		<option value="08">Agosto</option>
        		<option value="09">Setembro</option>
        		<option value="10">Outubro</option>
        		<option value="11">Novembro</option>
        		<option value="12">Dezembro</option>
        	</select>
        </div>
    </div>

    <div class="form-group">
        <label for="tx_name" class="col-md-4 control-label obrigatorio">Ano:</label>
        <div class="col-md-6">
        	<select type="date" class="form-control select2-native" id="dt_ano" name="dt_ano" required autofocus></select>
        </div>
    </div>

    <div class="form-group">
      <label for="show_evento_projeto" class="col-md-4 control-label">Projeto:</label>
      <div class="col-md-6">
        <select type="text" class="form-control select2-native" id="form_search_projeto" >
            <option value="0" selected>TODOS</option>
        </select>
      </div>
    </div>

    <!-- <div class="form-group">        
        <label class="col-md-4 control-label">Situação</label>
        <div class="col-md-6">
            <select class="form-control select2-native" id="form_search_situacao">
                <option value="2">TODOS</option>
                <option value="1">Visível</option>
                <option value="0">Invisível</option>
            </select>
        </div>
    </div> -->

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
		    <button id="btn_procurar" type="submit" class="btn btn-poli">
		        Procurar
		    </button>
		</div>
	</div>
</div>