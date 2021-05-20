@extends('adminlte::page')

@section('title', 'Fale com a Diretoria')

@section('content_header')
  <h1><i class="fa fa-fw fa-comments-o"></i>Fale com a Diretoria</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-fw fa-comments-o"></i>Fale com a Diretoria</a></li>
  </ol>     
@endsection

@section('content')
<div class="row">
    	<!-- BOX DE Sugestoes com titulo, pergunta e resposta com datas tambem -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			Nova Mensagem:
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>	    				 				
	    			</div>
    			</div>
    			<div class="box-body">
                    
                    <div class='form-group'>
                        <input class='form-control nova-titulo' name='nova-titulo' maxlength='60'  required='' placeholder='Título da Mensagem'></input>
                    </div>
                    <div class='form-group'>
                        <textarea class='form-control nova-msg' name='nova-msg' maxlength='200' required='' placeholder="Escreva aqui sua sugestão, reclamação ou mesmo elogio para a família Poli."></textarea>
                    </div>
                    <div class='box-footer'>
                        <p class='text-warning'><i>Alerta: As mensagens enviadas são identificadas. Obrigado pela colaboração!</i></p>
                        <p class='text-warning'>Tamanho Máximo da Mensagem: 200 caracteres.</p>
                        <button class="btn-lg btn-poli nova-enviar pull-right" type="button">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
 </div>
              
@foreach($mensagens as $chat)


<div class="row">
    	<!-- BOX DE Sugestoes com titulo, pergunta e resposta com datas tambem -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{ $chat->tx_titulo }}
	    			</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-danger removeMsg" type="button" data-toggle="modal" data-target="#modal_removeMsg" data-id_msg="{{ $chat->id_msg }}">
	    					<i class="fa fa-trash"></i>
	    				</button>    
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>	    				 				
	    			</div>
    			</div>
    			<div class="box-body">
                    <div>
                        <h4>
                        Mensagem Enviada:
                        </h4>
                        <h4 class="pull-right">
                            Enviada em: {{ $chat->dt_envio }}
                        </h4>
                            <h5>
                                <p>
                            {{ $chat->tx_envio }}
                                <p>
                            </h5>
                    </div> 
                    <div>
                        <h4>
                        Resposta:
                        </h4>
                    @if($chat->tx_resposta != '')    
                        <h4 class="pull-right">
                            Respondia em: {{ $chat->dt_resposta }}
                        <h5>
                            <p>
                            {{ $chat->tx_resposta }}
                            </p>
                        </h5>
                    @else
                    <h5>
                        <p>
                        Aguardando Resposta.
                        </p>
                    </h5>    
                    @endif    
                    </div>    
    			</div>
    		</div>
    	</div>
  </div>  
	
@endforeach

<div class="modal fade" id="modal_removeMsg" role="dialog" aria-labelledby="modal_removeMsg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">Confirmar Exclusão:</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">

                        <input type="hidden" id="id_msg">
                        <p class='text-danger'><i>A mensagem será permanentemente excluída do sistema!</i></p>
                        
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <a id="btn_submit_remove" class="btn btn-danger"><i class="fa fa-trash"></i>Excluir</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/chat.js') }}"></script>

@endsection