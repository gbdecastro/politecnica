//Preencher Selects do Formulario de Pesquisa
//No Done fica a inicializacao do Calendario
$.ajax({
  type: 'GET',
  url: 'calendario/projetos/ano/trabalhados',
  dataType: "json"
}).done(function(data){
    i = data[0];
    j = data[1];
    for(i; i<=j; i++){
      $('#dt_ano').append('<option value='+i+'>'+i+'</option>');
    }

    /*
      setando nos select do form de pesquisa
      os projetos do usuario
    */
    $.ajax({
      type:'GET',
      url:'calendario/projetos',
      dataType: "json",
    }).done(function(data){

        $.each(data,function(i, entry){
          var option = '<option value='+entry.id_projeto+'>'+entry.id_projeto+'-'+entry.tx_projeto+'</option>';
          $('#form_search_projeto').append(option);
        });

    });

    getCurrentDateForFormSeach();
    getCalendario();
    getResumo($('#form_search_projeto').val());
});

//Setando o Mes e Ano Atual nos Selects do Formulario de Pesquisa
function getCurrentDateForFormSeach(){
  var date = new Date();
  month = date.getMonth();
  year = date.getFullYear();

  month++;
  //preciso formatar para o fullcalendar
  if(month <= 9)
    month = "0"+month;

  $("#dt_mes").val(month).trigger("change");
  $("#dt_ano").val(year).trigger("change");
}

//Variavel Utilizadas nao Funcao get Calendario 
var eventos;

//Funcao Geradora do Calendario
function getCalendario(){

    toastr.info("Procurando dados");

    $('#btn_procurar').prop('disabled',true);

    var mes = $("#dt_mes").val();
    var ano = $("#dt_ano").val();
    var projeto = $('#form_search_projeto').val();
    var initialLangCode = 'pt-br';
    //var situacao = $('#form_search_situacao').val();

    //ajax para carregar o calendario na data com os dados
    $.ajax({
       type:'GET',
       url:'calendario/funcionario/'+ano+'/'+mes+'/'+projeto,
       dataType: 'json',
    }).done(function(data){
        toastr.remove();
        eventos = [];
        $.each(data, function(i, entry){
          eventos.push({
            id: entry.id_funcionario,
            color: entry.tx_color,
            id_projeto: entry.id_projeto,
            tx_projeto: entry.tx_projeto,
            nb_despesa: entry.nb_despesa,
            title: entry.id_projeto+' - '+entry.nb_horas_trabalho+' hrs',
            start: entry.dt_trabalho,
            nb_horas_trabalho: entry.nb_horas_trabalho,
            description: entry.tx_projeto+' '+entry.nb_horas_trabalho
          });
        });

        $('#calendario').fullCalendar('destroy');

        $('#calendario').fullCalendar({
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultDate: ano+'-'+mes,
            lang: initialLangCode,
            editable: false,
            events: eventos,
            height: 600,
            showNonCurrentDates: false,
            //ao clicar no EVENTO.
            eventClick: function(calEvent, jsEvent, view) {

                //carregar dados
                //primeiro preciso carregar os projetos do usuario.
                $.ajax({
                  type:'GET',
                  url:'calendario/projetos',
                  dataType: "json",
                }).done(function(data){
                    $('#show_evento_projeto').html('');

                    $.each(data,function(i, entry){
                      if(calEvent.id_projeto == entry.id_projeto){
                        var option = '<option value='+entry.id_projeto+' selected>'+entry.id_projeto+'-'+entry.tx_projeto+'</option>';
                      }else{
                        var option = '<option value='+entry.id_projeto+'>'+entry.id_projeto+'-'+entry.tx_projeto+'</option>';
                    }
                      $('#show_evento_projeto').append(option);
                    });
                });

                //campo que mostrar a Data.
                $('#show_evento_dt_evento').val(calEvent.start.toISOString().slice(0, 10));

                //agora carrego o dado de horas
                $('#show_evento_nb_horas').val(calEvent.nb_horas_trabalho);

                //agora carrego o dado de despesa
                if(calEvent.nb_despesa==null){
                    calEvent.nb_despesa = 0;
                }
                $('#show_evento_nb_despesa').val(calEvent.nb_despesa);


                //Nome do Modal:
                $('.modal-title').html(calEvent.id_projeto+' - '+calEvent.tx_projeto);

                $('#modal_show_evento').modal('show');
            },

            dayClick: function(date, jsEvent, view) {
              

              var myDate = new Date();

              if (date < myDate) {
              //modal
              $('#modal_create_evento').modal('show');

              //Nome do Modal:
              $('.modal-title').html('Cadastrar Horas Trabalhadas');

              //carregar dados de projeto no select
              $.ajax({
                type:'GET',
                url:'calendario/projetos',
                dataType: "json",
                success: function(data){
                  $('#create_evento_projeto').html('');

                  $.each(data,function(i, entry){
                    var option = '<option value='+entry.id_projeto+'>'+entry.id_projeto+'-'+entry.tx_projeto+'</option>';
                    $('#create_evento_projeto').append(option);
                  });
                }
              });

              //carregar a data do click
              $('#create_evento_dt_evento').val(date.toISOString().slice(0, 10));                             
              } else {
                alert("Favor Inserir Horas em Data Válida");
                return false;
              }
           }                                                 
        });

        $('#calendario').fullCalendar('gotoDate',ano+'-'+mes);

        $('#btn_procurar').prop('disabled',false);        

        toastr.success("Dados Encontrados");
    });
    toastr.remove();
}

//FUNCAO DO RESUMO
function getResumo(id_projeto){
  var mes = $("#dt_mes").val();
  var ano = $("#dt_ano").val();
  $.ajax({
    type:'get',
    url:'calendario/resumoMensal/'+ano+'/'+mes+'/'+id_projeto,
    dataType: 'json',
  }).done(function(response){
    toastr.remove();
    resumo = [];
    $('#resumo').html('');

    $('#corBox').removeClass("bg-poli");
    $('#corBox').removeClass("bg-yellow");

    horas = 0;

    $.each(response, function(i, entry){

      horas =  horas + parseInt(entry.nb_horas);

      $('#resumo').append(
        '<div class="box-body">'+
            '<div class="info-box">'+
                '<span class="info-box-icon" style="background-color:'+entry.tx_color+'">'+
                  '   <i class="fa fa-object-group" style="color:#FFF"></i>'+
                '</span>'+
                '<div class="info-box-content">'+
                    '<span class="info-box-text">'+entry.id_projeto+'-'+entry.tx_projeto+'</span>'+
                    '<span class="info-box-number">'+entry.nb_horas+'hs</span>'+
                    '<span class="info-box-number">R$ '+entry.nb_despesas+'</span>'+
                '</div>'+
            '</div>'+                     
        '</div>');        
    });

    $.ajax({
      type:'get',
      url: '../banco_horas/dias_uteis/'+mes+'/'+ano,
      dataType: 'text'
    }).done(function (response){

      $('.cargaHoras').empty('')
      $('.cargaHoras').html(response)

      var porc = ((horas*100)/response);
      porc = porc.toPrecision(4);

      if(horas < response){
        $('#corBox').addClass("bg-yellow");
      }else{
        $('#corBox').addClass("bg-poli");        
      }
      $('#horasAcumuladas').html(horas);
  
      $('#progressoHoras').css("width",(porc+"%"));
      $('.progress-description').html(porc+"%");  
    })  
  });
}

//Botao Procurar da Box Formulario de Pesquisa
$('#btn_procurar').click(function(){
    getCalendario();
    getResumo($('#form_search_projeto').val());
    btnSpinAjax($(this),$(this).html());
});

//Validacao do Formulario Formulario create_evento
$('#create_evento').bootstrapValidator({
  message: 'This value is not valid',
  feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
  },
  fields: {
    create_evento_nb_horas: {
          message: 'Horas Trabalhadas Inválidas',
          validators: {
              notEmpty: {
                  message: 'Campo Obrigatório'
              },
              between: {
                  min: 1,
                  max: 24,
                  message: 'Mínimo de 1 Hora e Máximo de 24 Horas'
              },
              regexp: {
                  regexp: /^[0-9_]+$/,
                  message: 'Somente Números'
              }
          }
      },
      create_evento_nb_despessa: {     
          validators: {         
              regexp: {
                regexp: /^[+-]?([0-9]*[.])?[0-9]+$/,
                message: 'Somente Números'
              }
          }
      }
  }
}).on('success.field.bv', function(e, data) {
  $('#btn_criar_evento').prop('disabled',false);
}).on('error.field.bv', function(e, data){
  $('#btn_criar_evento').prop('disabled',true);
});

//Botao Criar do Modal
$('#btn_criar_evento').click(function(){
  btnSpinAjax($(this),$(this).html());
  $.ajax({
    type:'POST',
    url: 'calendario/funcionario',
    dataType: 'json',
    data:{
      dt_trabalho: $('#create_evento_dt_evento').val(),
      id_projeto: $('#create_evento_projeto').val(),
      nb_horas_trabalho: $('#create_evento_nb_horas').val(),
      nb_despesa: $('#create_evento_nb_despessa').val()
    },
    success: function(data){
      toastr.success(data.msg);
      $('#modal_create_evento').modal('hide');
      $('#calendario').fullCalendar('destroy');
      $('#create_evento_dt_evento').val('');
      $('#create_evento_projeto').val('');
      $('#create_evento_nb_horas').val('');
      $('#create_evento_nb_despessa').val('');
    },
    error: function(jqXHR, textStatus, errorThrown) {
      toastr.error(textStatus);
    }    
  }).done(function(){
    getCalendario();
    getResumo($('#form_search_projeto').val());
  });
});

//Botao Excluir do Modal
$('#btn_excluir_evento').click(function(){
  btnSpinAjax($(this),$(this).html());
  $.ajax({
    type:'DELETE',
    url: 'calendario/funcionario',
    dataType: 'json',
    data:{
      dt_trabalho: $('#show_evento_dt_evento').val(),
      id_projeto: $('#show_evento_projeto').val()
    },
    success: function(data){
      toastr.success(data.msg);
      $('#modal_show_evento').modal('hide');
      $('#calendario').fullCalendar('destroy');
    },
    error: function(jqXHR, textStatus, errorThrown) {
      toastr.error(textStatus);
    }        
  }).done(function(){
    getCalendario();
    getCurrentDateForFormSeach();
    getResumo($('#form_search_projeto').val());    
  });   
});

//Validacao do Formulario Formulario Show_evento (Editar)
$('#show_evento').bootstrapValidator({
  message: 'This value is not valid',
  feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
  },
  fields: {
    show_evento_nb_horas: {
          message: 'Horas Trabalhadas Inválidas',
          validators: {
              notEmpty: {
                  message: 'Campo Obrigatório'
              },
              between: {
                  min: 1,
                  max: 24,
                  message: 'Mínimo de 1 Hora e Máximo de 24 Horas'
              },
              regexp: {
                  regexp: /^[0-9_]+$/,
                  message: 'Somente Números'
              }
          }
      },
      show_evento_nb_despesa: {     
          validators: {           
              regexp: {
                regexp: /^[+-]?([0-9]*[.])?[0-9]+$/,
                message: 'Somente Números'
              }
          }
      }
  }
}).on('success.field.bv', function(e, data) {
  $('#btn_editar_evento').prop('disabled',false);
}).on('error.field.bv', function(e, data){
  $('#btn_editar_evento').prop('disabled',true);
});

//Botao Editar do Modal
$('#btn_editar_evento').click(function(){
  btnSpinAjax($(this),$(this).html());
  $.ajax({
    type:'PUT',
    url: 'calendario/funcionario',
    dataType: 'json',
    data:{
      dt_trabalho: $('#show_evento_dt_evento').val(),
      id_projeto: $('#show_evento_projeto').val(),
      nb_horas_trabalho: $('#show_evento_nb_horas').val(),
      nb_despesa: $('#show_evento_nb_despesa').val()
    },
    success: function(data){
      toastr.success(data.msg);
      $('#modal_show_evento').modal('hide');
      $('#calendario').fullCalendar('destroy');
    },
    error: function(jqXHR, textStatus, errorThrown) {
      toastr.error(textStatus);
    }        
  }).done(function(){
    getCalendario();
    getResumo($('#form_search_projeto').val());
  }); 
});
