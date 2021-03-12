<div>
    <div id="modal_mapa" class="modal fade" role="dialog">
        <div class="modal-fullscren">
            <div class="modal-content modal-content-fullscreen">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">100% Complete</span>
                </div>
                </div>
                </div>
               
                <div class="modal-body">
                
                <input type="hidden" id="id_usuario">
                <input type="hidden" id="ano">
                @for ($i = 1; $i < 13; $i++)
                @switch($i)
											@case(1)
											<div class="row">
											@break
											@case(4)
                                            <div class="row">
                                            @break
                                            @case(7)
                                            <div class="row">
                                            @break
                                            @case(10)
                                            <div class="row">
                                            @break
                                            @default
                @endswitch
                        <div class="col-md-4">
                            <div class="box box-poli">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                       {{ $meses[$i] }} / {{ $ano }}
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-toll" type="button" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="tableAval" class="table table-striped no-margin">
                                        <thead>
                                            <tr>
                                                <th>Colaborador</th>
                                                <th>P.A.</th>
                                                <th>P.D.</th>
                                                <th>PT.</th>
                                            </tr>
                                        </thead>
                                        <tbody class="{{$i}}" id="entryResumo">
                                             	
                                            						
                                        </tbody>
                                    </table>
				            	</div> 
                             </div>
                           </div>  
                        @switch($i)
											@case(3)
											</div>
											@break
											@case(6)
                                            </div>
                                            @break
                                            @case(9)
                                            </div>
                                            @break
                                            @case(12)
                                            </div>
                                            @break
                                            @default
                        @endswitch
                        @endfor   
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>