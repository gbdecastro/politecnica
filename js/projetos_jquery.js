$('.icheck_empresa').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
});

//EDIT_BLADE
$('.select2-tag').select2({
  width: '100%',
  allowClear: true,
  tags: true
});

$.ajax({
  type: 'GET',
  url: 'vue_grupos',
  success: function success(data) {
    data = JSON.parse(data);

    $.each(data, function (i, entry) {
      var option = '<option value=' + entry.id_grupo + '>' + entry.tx_grupo + '</option>';
      $('#id_grupo').append(option);
      $('#id_grupo_edit').append(option);
    });
  }
});

$.ajax({
  type: 'GET',
  url: 'empresas'
}).done(function(data) {
    data = JSON.parse(data);

    $.each(data, function (i, entry) {
      var option = '<option value=' + entry.id_empresa + '>' + entry.tx_empresa + '</option>';
      $('#id_empresa').append(option);
      $('#id_empresa_edit').append(option);
    });
    $('.select2-tag').select2({
      width: '100%',
      allowClear: true,
      tags: true
    });      
});

$('#novo_projeto').click(function () {
  /*atualizo nos MODALS*/
  $('#id_empresa').select2('destroy');
  $('#id_empresa_edit').select2('destroy');
  $.ajax({
    type: 'GET',
    url: 'empresas',
  }).done(function (data) {

      data = JSON.parse(data);
      option = '';

      $.each(data, function (i, entry) {
        option += '<option value=' + entry.id_empresa + '>' + entry.tx_empresa + '</option>';
      });

      $('#id_empresa').html(option);
      $('#id_empresa_edit').html(option);
      
      //CREATE_BLADE
      $('.select2-tag').select2({
        width: '100%',
        allowClear: true,
        tags: true
      });        
  });
});