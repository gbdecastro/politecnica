<div id="modal_projetos" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
				<h4 class="modal-title">Projetos</h4>
			</div>
			<div class="modal-body">
				<div class="progress">
				  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				    <span class="sr-only">100% Complete</span>
				  </div>
				</div>				
                <table id="table_projetos" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Projetos</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="projeto in projetos">
                            <td>@{{ projeto.id_projeto }} - @{{ projeto.tx_projeto }}</td>
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>