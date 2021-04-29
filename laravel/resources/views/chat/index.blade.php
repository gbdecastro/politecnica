@extends('adminlte::page')

@section('title', 'Box de Sugestões')

@section('content_header')
  <h1><i class="fa fa-fw fa-comments-o"></i>Box de Sugestões</h1>
  <ol class="breadcrumb">
    <li class="active"><a href="#"><i class="fa fa-fw fa-comments-o"></i>Box de Sugestões</a></li>
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
                        <input class='form-control nova-titulo' placeholder='Título da Mensagem'>
                    </div>
                    <div class='form-group'>
                        <textarea class='form-control nova-msg' placeholder="Escreva aqui sua sugestão, reclamação ou mesmo elogio para a família Poli."></textarea>
                    </div>
                    <div class='box-footer'>
                        <p class='text-warning'><i>Alerta: As mensagens enviadas são identificadas. Xingamentos serão respondidos dentro das devidas proporções. Obrigado pela colaboração!</i></p>
                        <a class="btn-lg btn-poli nova-enviar pull-right">Enviar</a>
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

@endsection

@section('js')


@endsection