<div id="create_funcionario">
    <div id="modal_create" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Novo projeto</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tx_name" class="control-label obrigatorio">Nome</label>
                        <input id="tx_name" type="text" class="form-control" name="tx_name" v-model="new_funcionario.tx_name" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="tx_email" class="control-label obrigatorio">E-Mail</label>
                        <input id="tx_email" type="email" class="form-control" name="tx_email" v-model="new_funcionario.tx_email" required>
                    </div>

                    <div class="form-group">
                        <label for="dt_admissao" class="control-label obrigatorio">Data de Admissão</label>
                        <input id="dt_admissao" type="date" class="form-control" name="dt_admissao" v-model="new_funcionario.dt_admissao" required>
                    </div>

                    <div class="form-group">
                        <label for="nb_nota" class="control-label">Nota</label>
                        <input id="nb_nota" type="text" value=0 class="form-control" name="nb_nota" v-model="new_funcionario.nb_nota" required>
                    </div>                    

                    <div class="form-group">
                        <label for="nb_category_user" class="control-label obrigatorio">Tipo de Usuario</label>
                        <select class="form-control select2-native" id="new_funcionario_categoria" name="nb_category_user" required>
                            <option value="0">Comum</option>
                            <option value="1">Administrador</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tx_funcao" class="control-label">Função</label>
                        <input id="tx_funcao" type="text" class="form-control" name="tx_funcao" v-model="new_funcionario.tx_funcao" required>
                    </div>                    

                    <div class="form-group">
                        <label for="tx_password" class="control-label obrigatorio">Senha</label>
                        <input id="tx_password" type="password" class="form-control" name="tx_password" v-model="new_funcionario.tx_password" required>
                    </div>

                    <div class="form-group" id="tx_password_confirm">
                        <label for="tx_password-confirm" class="control-label obrigatorio">Confirmar Senha</label>
                        <input type="password" class="form-control" v-model="new_funcionario.tx_password_confirmation" name="tx_password_confirmation" required>                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" @click="createFuncionario" id="btn_submit_register" class="btn btn-poli" disabled>Criar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>                    