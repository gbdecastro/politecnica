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
                        <label for="tx_telefone" class="control-label">Telefone</label>
                        <input id="tx_telefone" type="text" class="form-control" name="tx_telefone" v-model="edit_funcionario.tx_telefone" required>
                    </div>        

					<div class="form-group">
                        <label for="id_lotacao" class="control-label obrigatorio">Lotado em</label>
                        <select class="form-control select2-native" id="edit_funcionario_id_lotacao" name="id_lotacao" required></select>
                    </div>                      

                    <div class="form-group">
                        <label for="nb_custo_hora" class="control-label">Custo/Hora</label>
                        <input id="nb_custo_hora" type="text" class="form-control" name="nb_custo_hora" v-model="edit_funcionario.nb_custo_hora" required>
                    </div>                                         
					
					<div class="form-group">
                        <label for="cs_tipo_contrato" class="control-label obrigatorio">Tipo de Contrato</label>
                        <select class="form-control select2-native" id="edit_funcionario_contrato" name="cs_tipo_contrato" required>
                            <option value="4">1. Sócio</option>
                            <option value="0">2. Fixo</option>
                            <option value="3">3. Estagiário</option>
							<option value="2">4. Temporário</option>
                            <option value="1">5. Terceiro</option>
                            <option value="5">6. Inativo</option>
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