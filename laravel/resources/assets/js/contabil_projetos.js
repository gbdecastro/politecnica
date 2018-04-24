//select2
$('.select2').select2({
  width: '100%',
  allowClear: true    
});


//ajax setup for laravel
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function criarCanvas(){

}

function addOverlay(){
	$('#box_form').append('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
}

function carregarProjetosFrom(){
	addOverlay();
	$.ajax({
		type: 'GET',
		url: 'painel/contabil/projetos/projetos',
		dataType: "json",
		success: function(data){
	        $.each(data,function(i, entry){
	          var option = '<option value='+entry.id_projeto+'>'+entry.tx_projeto+'</option>';
	          $('#slc_projeto').append(option);
	        });
		}
	 });
	$('.overlay').remove();
}

function carregarAnoForm(){
	addOverlay();
	$.ajax({
		type: 'GET',
		url: 'painel/contabil/projetos/ano/'+$('#slc_projeto').val(),
		dataType: "json",
		success: function(data){
			i = data[0];
			j = data[1];
			for(i; i<=j; i++){
			  $('#dt_ano').append('<option value='+i+'>'+i+'</option>');
			}
		}
	 });
	$('.overlay').remove();
}
carregarProjetosFrom();

$('#dt_ano').change(function(){
	carregarProjetosFrom();
});