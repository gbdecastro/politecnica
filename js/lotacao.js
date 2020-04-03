function dias_uteis(){

    $.ajax({
        type:'get',
        url: '../lotacao/dias_uteis'
    }).done(function (response){
        $.each(response, function(i, entry){
            var e = $($('.slc-dias-uteis')[i])
            e.val(entry.nb_dias).trigger("change")
        })
    })  
}

$(function(){

    dias_uteis()

    $('.select2-native').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: '../lotacao/mudar_dias_uteis',
            data:{
                id_diasuteis: $(this).attr("data-id_diasuteis"),
                nb_mes: $(this).attr("data-mes"),
                nb_dias: $(this).val()
            }
        }).done(function(){
            dias_uteis()
        })
    }); 

    $('#btn_submit_edit').on('click', function(){
        $.ajax({
            type:'post',
            url: '../lotacao/mudarHoras',
            data:{
                id_lotacao: $('input#id_lotacao').val(),
                nb_horas: $('input#nb_horas').val()
            }
        }).done(function (response){
          location.reload(true)
        })         
    });

    $('#modal_edit_lotacao').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_lotacao = button.data('id-lotacao')
        var tx_lotacao = button.data('tx-lotacao')
        var nb_horas = button.data('nb-horas')

        var modal = $(this)
        
        modal.find('input#nb_horas').val(nb_horas)
        modal.find('input#id_lotacao').val(id_lotacao)

        modal.find('h4.modal-title').text('Horas Diárias: '+tx_lotacao)

      })

      $('#modal_edit_diasuteis').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_lotacao = button.data('id-lotacao')
        var tx_lotacao = button.data('tx-lotacao')
        var id_diasuteis = button.data('id-diasuteis')

        var modal = $(this)
        
        modal.find('select#id_diasuteis').val(id_diasuteis)
        modal.find('input#id_lotacao_i').val(id_lotacao)

        modal.find('h4.modal-title').text('Alterar Calendário: '+tx_lotacao)

      })

      $('#btn_submit_edit_diasuteis').on('click', function(){
        $.ajax({
            type:'post',
            url: '../lotacao/mudarCalendario',
            data:{
                id_lotacao: $('input#id_lotacao_i').val(),
                id_diasuteis: $('select#id_diasuteis').val()
            }
        }).done(function (response){
           location.reload(true)
        })         
    });

})