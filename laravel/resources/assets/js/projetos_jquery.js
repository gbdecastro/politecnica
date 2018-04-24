//ajax setup for laravel
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(".select2").select2({
  width: '100%',
  placeholder: "Selecione uma Opção",
  allowClear: true       
});

$("#id_empresa_edit").select2({
  width: '100%',
  placeholder: "Selecione uma Opção",
  allowClear: true,    
  tags: "true"
});

$("#id_empresa").select2({
  width: '100%',
  placeholder: "Selecione uma Opção",
  allowClear: true,    
  tags: "true"
});

$.ajax({
  type:'GET',
  url:'vue_grupos',
  success: function(data){
    data = JSON.parse(data);

    $.each(data,function(i, entry){
      var option = '<option value='+entry.id_grupo+'>'+entry.tx_grupo+'</option>'
      $('#id_grupo').append(option);
      $('#id_grupo_edit').append(option);
    });   
  }
});

$.ajax({
  type:'GET',
  url:'empresas',
  success: function(data){
    data = JSON.parse(data);

    $.each(data,function(i, entry){
      var option = '<option value='+entry.id_empresa+'>'+entry.tx_empresa+'</option>'
      $('#id_empresa').append(option);
      $('#id_empresa_edit').append(option);
    });
  }
});

$('#novo_projeto').click(function(){
  /*atualizo nos MODALS*/
  $('#id_empresa').select2('destroy');
  $('#id_empresa_edit').select2('destroy');
  $.ajax({
    type:'GET',
    url:'empresas',
    success: function(data){
      
      data = JSON.parse(data);
      option = '';
      
      $.each(data,function(i, entry){
        option += '<option value='+entry.id_empresa+'>'+entry.tx_empresa+'</option>';
      });

      $('#id_empresa').html(option);
      $('#id_empresa_edit').html(option);
    }
  });

  $("#id_empresa").select2({
    width: '100%',
    placeholder: "Selecione uma Opção",
    allowClear: true,    
    tags: "true"
  });
  $("#id_empresa_edit").select2({
    width: '100%',
    placeholder: "Selecione uma Opção",
    allowClear: true,    
    tags: "true"
  }); 

});