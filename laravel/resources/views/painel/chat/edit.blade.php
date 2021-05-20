<div class="modal fade" id="modal_removeMsg" role="dialog" aria-labelledby="modal_removeMsg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">Confirmar Exclusão:</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                        <input type="hidden" id="id_msg">
                        <p class='text-danger'><i>A mensagem será permanentemente excluída do sistema!</i></p>
                        
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <a id="btn_submit_remove" class="btn btn-danger"><i class="fa fa-trash"></i>Excluir</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_respostaMsg" role="dialog" aria-labelledby="modal_respostaMsg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">Alterar Resposta:</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                
                    <div class="col-md-12">
                    <h5>
                    <i id='resp-original'></i>
                    </h5>
                        <input type="hidden" id="id_ed-msg">

                        <div class="form-group">
                            <label for="edit-resposta" class="control-label edit-resposta obrigatorio">Nova Resposta:</label>
                            <textarea class='form-control edit-resposta' id='edit-resposta' maxlength='200' required='' ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btn_submit_edit-resposta" class="btn btn-poli"><i class='fa fa-send'></i>  Enviar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>