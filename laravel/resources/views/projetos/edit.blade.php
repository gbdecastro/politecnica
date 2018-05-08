<div id="edit_projeto">
	<div id="modal_edit" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Editar Projeto</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="tx_projeto" class="obrigatorio">Nome:</label>
						<input type="text" name="tx_projeto" class="form-control" v-model="edit_projeto.tx_projeto" required>
					</div>
					
					<div class="form-group">
						<label for="id_grupo_edit" class="label-control obrigatorio">Grupo:</label>
						<input type="text" id="id_grupo_edit" v-model="edit_projeto.tx_grupo" class="form-control" disabled>
					</div>

					<div class="form-group">
						<label for="id_projeto" class="obrigatorio">Código:</label>
						<input type="text" name="id_projeto_edit" class="form-control" v-model="edit_projeto.id_projeto" disabled>
					</div>					

					<div class="form-group">
						<label for="cs_status_edit" class="label-control obrigatorio">Status: </label>
						<select name="" id="cs_status_edit" class="form-control obrigatorio select2-native">
							<option value="0">Investimento</option>
							<option value="1">Contratado</option>
							<option value="2">Favor</option>
							<option value="3">Permanente</option>
						</select>
					</div>					

					<div class="form-group">
						<label for="id_empresa_edit" class="label-control obrigatorio">Empresas:</label>
						<select id="id_empresa_edit" class="form-control obrigatorio select2-tag" required></select>
					</div>
					<div class="form-group">
						<label for="" class="checkbox-inline">
							<input type="checkbox" class="icheck_empresa" value="0" id="edit_projeto_new_empresa">
							Nova Empresa
						</label>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" @click="updateProjeto(edit_projeto)" id="btn_editar_form" class="btn btn-poli">Editar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</div>