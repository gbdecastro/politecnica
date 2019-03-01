<div>
    <div id="modal_calendario" class="modal fade" role="dialog">
        <div class="modal-fullscren">
            <div class="modal-content modal-content-fullscreen">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Calendário</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-poli">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        Pesquisar Histórico
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-toll" type="button" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button class="btn btn-box-toll" type="button" data-widget="remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    @include('calendario.form_pesquisa')
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="box box-poli">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            Calendário de Horas
                                        </h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-toll" type="button" data-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button class="btn btn-box-toll" type="button" data-widget="remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div id="calendario"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>