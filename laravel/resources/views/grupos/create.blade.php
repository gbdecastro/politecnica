<div id="create_grupo">
	<div id="modal_create" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Novo Grupo</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="tx_grupo" class="obrigatorio">Nome:</label>
						<input type="text" name="tx_grupo" id="tx_grupo" class="form-control" v-model="new_grupo.tx_grupo" required>
					</div>
					<div class="form-group">
						<label for="tx_color" class="obrigatorio">Cor:</label>
						<input type="color" id="new_grupo_color" class="form-control" required>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" @click="createGrupo" id="btn_submit_create" class="btn btn-poli" disabled>Criar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</div>