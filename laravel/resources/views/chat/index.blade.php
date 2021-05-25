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
                        <h5 class='text-warning'><i class="fa fa-exclamation"></i>  <i>  As mensagens enviadas são identificadas e não poderão ser alteradas após envio. Agradecemos pela colaboração!</i></h5>
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
<script src="{{ asset('js/chat.js') }}"></script>

@endsection