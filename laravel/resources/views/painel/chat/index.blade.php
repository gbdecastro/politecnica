@extends('adminlte::page')

@section('title', 'Central de Mensagens')

@section('content_header')
<h1>
  	<i class="fa fa-envelope-o"></i>Central de Mensagens
    <small>Painel > Central de Mensagens</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Painel</a>
    </li>
    <li>
        <a href="#">
		<i class="fa fa-envelope-o"></i>Central de Mensagens</a>
    </li>
</ol>
  
@endsection

@section('content')
@foreach($lotacao as $local)
<div class="row">
    	<!-- BOX DE Mensagens por Lotacao -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{ $local->tx_lotacao }} - Mensagens
	    			</h3>
	    			<div class="box-tools pull-right">
	    				<button class="btn btn-box-toll" type="button" data-widget="collapse">
	    					<i class="fa fa-minus"></i>
	    				</button>	    				 				
	    			</div>
    			</div>
    			<div class="box-body">
@foreach($mensagens as $chat)
@if($chat->id_lotacao == $local->id_lotacao)
<div class="row">
    	<!-- BOX DE Sugestoes com titulo, pergunta e resposta com datas tambem -->
		<div class="col-md-12">
    		<div class="box box-poli">
    			<div class="box-header with-border">
	    			<h3 class="box-title">
	    			{{$chat->tx_name}} - {{ $chat->tx_titulo }} -  {{ $chat->dt_envio }}
	    			</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-danger removeMsg" type="button" data-id_msg="{{ $chat->id_msg }}">
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
                        Mensagem:
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
                        <h4 class="pull-right text-success">
                            Respondia em: {{ $chat->dt_resposta }}
                        </h4>    
                        <h5>
                            <p>
                            {{ $chat->tx_resposta }}
                            </p>
                        </h5>
                    @else
                    
                    <div class='form-group'>
                        <input id='resposta{{$chat->id_msg}}' type='text' class='form-control' required='' placeholder="Aguardando Resposta."></input>
                    </div>
                    <button class="btn btn-poli" type="button" data-id_msg="{{ $chat->id_msg }}" data-toggle="modal" data-target="#modal_responder">
                            <i class="fa fa-reply"><b>  Responder</b></i>
                    </button> 
                    @endif    
                    </div>    
    			</div>
    		</div>
    	</div>
  </div>  
@endif	
@endforeach
                       
    			</div>
    		</div>
    	</div>
  </div>  
@endforeach
@endsection

@section('js')


@endsection