<!-- Modal -->
<div id="modal_show_evento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form id="show_evento">
          <div class="form-group">
            <label for="show_evento_dt_evento" class="control-label">Dia de Trabalho: </label>
            <input type="date" class="form-control" name="show_evento_dt_evento" id="show_evento_dt_evento" disabled>
          </div>  
                
          <div class="form-group">
            <label for="show_evento_projeto" class="control-label">Projeto: </label>
            <select type="text" class="form-control select2-native" id="show_evento_projeto" disabled></select>
          </div>

          <div class="form-group">
            <label for="show_evento_nb_horas" class="control-label obrigatorio">Horas Trabalhadas: </label>
            <input type="text" class="form-control" name="show_evento_nb_horas" id="show_evento_nb_horas" value="2">
          </div>

          <div class="form-group">
            <label for="show_evento_nb_despesa" class="control-label">Despesa: </label>
            <input type="text" class="form-control" name="show_evento_nb_despesa" id="show_evento_nb_despesa" value="0">
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-poli" id="btn_editar_evento">Editar</button>
        <button type="button" class="btn btn-danger" id="btn_excluir_evento">Excluir</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>