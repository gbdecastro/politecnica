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
                            <div class="box box-poli">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        Acumulado Mensal
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
                                    <div class="alert alert-info">
                                        <h4><i class="icon fa fa-info"></i>- Banco de Horas - Saldo: <b id="saldoHoras"></b>
                                            hs</h4>
                                        <h5>Carga Horária Obrigatória para <b id="cargaData"></b> : <b class="cargaHoras"></b>
                                            hs</h5>
                                        <cite>Atenção! Todo o dia primeiro de cada mês é contabilizado o Saldo de
                                            Horas.</cite>
                                    </div>
                                    <div class="info-box bg-yellow" id="corBox">
                                        <span class="info-box-icon"><i class="fa fa-object-group"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Horas Acumuladas</span>
                                            <span id="horasAcumuladas" class="info-box-number"></span>

                                            <div class="progress">
                                                <div id="progressoHoras" class="progress-bar" style="width: 50%"></div>
                                            </div>
                                            <span class="progress-description">

                                            </span>
                                        </div>
                                    </div>
                                    <div id="resumo"></div>
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