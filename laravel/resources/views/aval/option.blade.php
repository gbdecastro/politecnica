@foreach($usuarios as $usuarios)
<option value="{{  $usuarios->id_usuario }}" >{{  $usuarios->tx_name }}</option>
@endforeach