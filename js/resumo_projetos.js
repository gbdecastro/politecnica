function addOverlay() {
	$('#box_form').append('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
}

function generateColor() {
	//NAO GERA BRANCO
	var o = Math.round, r = Math.random, s = 255;
	var r = 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 0.5 + ')';
	if(r != 'rgba(255,255,255,0.5)')
		return r;
	else
		generateColor();
}

function formatoMoeda(num) {
    return "R$ " + num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function carregarAnoForm() {
	addOverlay();
	$.ajax({
		type: 'GET',
		url: 'projetos/ano',
		dataType: "json",
	}).done(function(data) {
		i = data[0];
		j = data[1];
		for (i; i <= j; i++) {
			$('#dt_ano').append('<option value=' + i + ' selected>' + i + '</option>');
		}
		$('.overlay').remove();			
	});
}
carregarAnoForm();

//-------------
//- Despesas por Projetos - Pie Chart
//-------------
var ctx = document.getElementById("chartDespesas").getContext('2d');
var objChartDespesa = new Chart(ctx, {
	type: 'pie',
	data: {
		labels: [],
		datasets: []
	},
	options: {
		tooltips: {
			enabled: true,
			mode: 'point',
			callbacks: {
				label: function label(tooltipItem, data) {
					var label = data.labels[tooltipItem.index];
					var valor = formatoMoeda(data.datasets[0].data[tooltipItem.index]);
					return label + ' ' + valor;
				}
			}
		}			
	}		
});

//-------------
//- Horas Trabalhdas por Projetos - Pie Chart
//-------------
var ctx = document.getElementById("chartHoras").getContext('2d');
var objChartHoras = new Chart(ctx, {
	type: 'pie',
	data: {
		labels: [],
		datasets: []
	}		
});

$('#box_despesas').hide();
$('#box_horas').hide();

$('#btn_gerar').click(function(){

	btnSpinAjax($(this),$(this).html());

	var mes = $('#dt_mes').val();
	var ano = $('#dt_ano').val();
	
	$('#total_despesa').html('');
	$('#total_horas').html('');

	$('#box_horas').fadeOut('slow');
	$('#box_despesas').fadeOut('slow');

	var arrayDataDespesa = [];
	var arrayDataHoras = [];
	var arrayColor = [];
	var arrayBorder = [];
	objChartDespesa.data.labels = [];
	objChartDespesa.data.datasets = [];

	$.ajax({
		type:'get',
		dataType: 'json',
		url:'projetos/despesas_projetos/'+ano+'/'+mes
	}).done(function(response){
        $.each(response, function (i, entry) {
			objChartDespesa.data.labels.push(entry.tx_projeto);
			arrayDataDespesa.push(entry.nb_despesa);
			
			//CONTROLE DE CORES REPETIDAS
			var corControle = [];
			var cor = generateColor();
			while(corControle.indexOf(cor) != '-1'){
				cor = generateColor();				
			}
			corControle.push(cor);
			arrayColor.push(cor);
			arrayBorder.push(cor.replace("0.5","1"));			
		});
		objChartDespesa.data.datasets.push({"data": arrayDataDespesa, "backgroundColor": arrayColor, "borderColor": arrayBorder ,"borderWidth": 1});
        objChartDespesa.update();
		$('.overlay').remove();
		$('#total_despesa').html("Total: "+formatoMoeda(response[0].valor_total));
		$('#box_despesas').fadeIn('slow');
	});


	objChartHoras.data.labels = [];
	objChartHoras.data.datasets = [];
	$.ajax({
		type:'get',
		dataType: 'json',
		url: 'projetos/horas_projetos/'+ano+'/'+mes
	}).done(function(response){
        $.each(response, function (i, entry) {
			objChartHoras.data.labels.push(entry.tx_projeto);
			arrayDataHoras.push(entry.nb_horas);		
		});
		objChartHoras.data.datasets.push({"data": arrayDataHoras, "backgroundColor": arrayColor, "borderColor": arrayBorder ,"borderWidth": 1});
        objChartHoras.update();
		$('.overlay').remove();
		$('#total_horas').html("Total: "+response[0].valor_total+"Hs");
		$('#box_horas').fadeIn('slow');
	});


});