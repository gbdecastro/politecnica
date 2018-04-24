
//ajax setup for laravel
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Funções de Transformações
function hexToRgbA(hex){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',0.7)';
    }
    throw new Error('Bad Hex');
}

function formatoMoeda (num) {
    return "R$"+num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}
//Fim de funções

function desepsasGrupos(){
  //-------------
  //- Despesas por Grupos - Bar Chart
  //-------------
  var ctx = document.getElementById("despesas_grupo").getContext('2d');
  var chart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
          datasets: []
      },
      options: {
          tooltips: {
              enabled: true,
              mode: 'point',            
              callbacks: {
                label: function(tooltipItem, data) {
                  var label = data.labels[tooltipItem.index];
                  return formatoMoeda(tooltipItem.yLabel);
                }
              }
          },        
          scales: {
              yAxes: [
                  {
                      ticks: {
                          callback: function(label, index, labels) {
                              return formatoMoeda(label);
                          }
                      }
                  }
              ]
          }
      }
  }); 

  $.ajax({
    type:'GET',
    url: 'despesas_grupos',
    dataType: 'json'
  }).done(function (data){
      var id_grupo_aux = 0;
      var cont = -1;
      $.each(data, function(i, entry){
        var id_grupo = entry.id_grupo;
        if(id_grupo != id_grupo_aux){
          chart.data.datasets.push({
            label: entry.tx_grupo,
            data: [entry.nb_despesa],
            backgroundColor: hexToRgbA(entry.tx_color),
            borderWidth: 1            
          });
          cont++;
          id_grupo_aux = id_grupo;
        }else{
          chart.data.datasets[cont].data.push(entry.nb_despesa);
        }
      });    
      chart.update();
      $('.overlay').remove();      
  });
}
desepsasGrupos();
