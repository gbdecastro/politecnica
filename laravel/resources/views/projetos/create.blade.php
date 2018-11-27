<div id="create_projeto">
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
						<label for="tx_projeto" class="label-control obrigatorio">Nome:</label>
						<input type="text" name="tx_projeto" class="form-control obrigatorio" v-model="new_projeto.tx_projeto" required>
					</div>
					
					<div class="form-group">
						<label for="id_grupo" class="label-control obrigatorio">Grupo:</label>
						<select id="id_grupo" class="form-control obrigatorio select2-native"  required>
						</select>
					</div>

					<div class="form-group">
						<label for="id_projeto" class="label-control obrigatorio">Código Projeto:</label>
						<input type="text" name="id_projeto" class="form-control obrigatorio" v-model="new_projeto.id_projeto" disabled>
					</div>					
					
					<div class="form-group">
						<label for="cs_status" class="label-control obrigatorio">Status</label>
						<select name="" id="cs_status" class="form-control obrigatorio select2-native">
							<option value="0">Contrato</option>
							<option value="1">Perene</option>
							<option value="2">Particular</option>
						</select>
					</div>

					<div class="form-group">
						<label for="id_empresa" class="label-control obrigatorio">Empresas:</label>
						<select id="id_empresa" class="form-control obrigatorio select2-tag"></select>
					</div>
					<div class="form-group">
						<input type="checkbox" class="icheck_empresa" value="0" id="create_projeto_new_empresa">
						Nova Empresa
					</div>						
				</div>
				<div class="modal-footer">
					<button type="submit" @click="createProjeto" class="btn btn-poli" disabled>Criar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</div>