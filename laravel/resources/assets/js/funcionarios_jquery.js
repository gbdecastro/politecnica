//ajax setup for laravel
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#vincular_projeto').click(function(){
	$('#add_id_projeto').html('');
});