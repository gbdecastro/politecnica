<div id="edit_grupo">
	<div id="modal_edit" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Editar Grupo</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="tx_grupo" class="obrigatorio">Nome:</label>
						<input type="text" name="tx_grupo" id="tx_grupo" class="form-control" v-model="edit_grupo.tx_grupo" required>
					</div>
					<div class="form-group">
						<label for="tx_color" class="obrigatorio">Cor:</label>
						<input type="color" id="edit_grupo_color" class="form-control" required>
					</div>						
				</div>
				<div class="modal-footer">
					<button type="submit" @click="updateGrupo(edit_grupo.id_grupo)" id="btn_submit_edit" class="btn btn-poli">Editar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</div>