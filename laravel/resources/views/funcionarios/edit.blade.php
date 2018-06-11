<div id="edit_funcionario">
    <div id="modal_edit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Editar Colaborador</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tx_name" class="control-label obrigatorio">Nome</label>
                        <input id="tx_name" type="text" class="form-control" name="tx_name" v-model="edit_funcionario.tx_name" required>
                    </div>

                    <div class="form-group">
                        <label for="tx_email" class="control-label obrigatorio">E-Mail</label>
                        <input id="tx_email" type="email" class="form-control" name="tx_email" v-model="edit_funcionario.tx_email" required>
                    </div>

                    <div class="form-group">
                        <label for="dt_admissao" class="control-label obrigatorio">Data de Admissão</label>
                        <input id="dt_admissao" type="date" class="form-control" name="dt_admissao" v-model="edit_funcionario.dt_admissao" required>
                    </div>                    
                    
                    <div class="form-group">
                        <label for="nb_nota" class="control-label">Nota</label>
                        <input id="nb_nota" type="text" class="form-control" name="nb_nota" v-model="edit_funcionario.nb_nota" required>
                    </div>                        
					
					<div class="form-group">
                        <label for="cs_tipo_contrato" class="control-label obrigatorio">Tipo de Contrato</label>
                        <select class="form-control select2-native" id="edit_funcionario_contrato" name="cs_tipo_contrato" required>
                            <option value="0">Fixo</option>
                            <option value="1">Eventual</option>
							<option value="2">Temporario</option>
                            <option value="3">Estagiario</option>
                        </select>
                    </div>
					
                    <div class="form-group">
                        <label for="nb_category_user" class="control-label obrigatorio">Tipo de Usuario</label>
                        <select class="form-control select2-native" id="edit_funcionario_categoria" name="nb_category_user" required>
                            <option value="0">Comum</option>
                            <option value="1">Administrador</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tx_funcao" class="control-label">Função</label>
                        <input id="tx_funcao" type="text" class="form-control" name="tx_funcao" v-model="edit_funcionario.tx_funcao" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" @click="updateFuncionario" id="btn_submit_edit" class="btn btn-poli">Editar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>                    