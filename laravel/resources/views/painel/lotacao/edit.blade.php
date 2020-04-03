<div class="modal fade" id="modal_edit_lotacao" role="dialog" aria-labelledby="modal_edit_lotacao">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                        <input type="hidden" id="id_lotacao">
                        
                        <div class="form-group">
                            <label for="nb_horas" class="control-label nb_horas obrigatorio">Carga Horária:</label>
                            <input id="nb_horas" type="text" class="form-control" name="nb_horas" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="modal-footer">
                <a id="btn_submit_edit" class="btn btn-poli">Mudar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_diasuteis" role="dialog" aria-labelledby="modal_edit_diasuteis">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                        <input type="hidden" id="id_lotacao_i">
                        
                        <div class="form-group">
                            <label for="id_diasuteis" class="control-label id_diasuteis obrigatorio">Selecionce Calendário:</label>
                            <select id="id_diasuteis" class="form-control" name="id_diasuteis" required>
									 	<option value="0">Calendário São Paulo</option>
                                        <option value="1">Calendário Manaus</option>
                                        <option value="2">Calendário HDA Manaus</option> 
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="modal-footer">
                <a id="btn_submit_edit_diasuteis" class="btn btn-poli">Mudar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>