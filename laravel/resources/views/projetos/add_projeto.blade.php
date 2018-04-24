<div>
	<div id="modal_add_projeto" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
					<h4 class="modal-title">Vincular Projeto</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id_projeto" class="label-control obrigatorio">Projeto:</label>
						<select class="form-control select2-native" id="add_id_projeto"></select>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" @click="addProjeto" id="btn_submit" class="btn btn-poli">Vincular</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</div>