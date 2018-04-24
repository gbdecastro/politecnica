<form id="create_evento">
  <!-- Modal -->
  <div id="modal_create_evento" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cadastrar Horas Trabalhadas</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="create_evento_dt_evento" class="control-label">Dia de Trabalho: </label>
              <input type="date" class="form-control" name="create_evento_dt_evento" id="create_evento_dt_evento" disabled>
            </div>
            <div class="form-group">
              <label for="create_evento_projeto" class="control-label obrigatorio">Projeto: </label>
              <select type="text" class="form-control select2-native" id="create_evento_projeto"></select>
            </div>
            <div class="form-group">
              <label for="create_evento_nb_horas" class="control-label obrigatorio">Horas Trabalhadas: </label>
              <input type="text" class="form-control" name="create_evento_nb_horas" id="create_evento_nb_horas" value="2">
            </div>

            <div class="form-group">
              <label for="create_evento_nb_despessa" class="control-label">Despesa: </label>
              <input type="text" class="form-control" name="create_evento_nb_despessa" id="create_evento_nb_despessa" value="0">
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-poli" id="btn_criar_evento" disabled>Criar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</form>