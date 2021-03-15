function resumoAnual(id_usuario,nb_ano){
    
    $.ajax({
        type:'get',
        url: './aval/resumoAnual/'+id_usuario+'/'+nb_ano,
    }).done(function (response){

        $.each(response, function(i, entry){

            $('tbody#entryResumo.'+entry.nb_mes).append(
                '<tr>'+
                '<td>'+entry.tx_name+'</td>'+
                '<td>'+entry.nb_proativ+'</td>'+
                '<td>'+entry.nb_produtiv+'</td>'+
                '<td>'+entry.nb_pontual+'</td>'+
                '</tr>');   
            
            
        })
        $('.progress').hide();
        $('.modal-body').show();
    })  
   
}

$(function(){

    $('#modal_mapa').on('show.bs.modal', function (event) {
        $('.modal-body').hide();
        $('.progress').show();
        var button = $(event.relatedTarget)

        var id_usuario = button.data('id-usuario')
        var tx_name = button.data('tx-name')
        var nb_ano = button.data('ano')

        var modal = $(this)
        
        modal.find('input#id_usuario').val(id_usuario)
        modal.find('input#ano').val(nb_ano)
        var e = $('.slc-anos')
        e.val(nb_ano).trigger("change")
        modal.find('h4.modal-title').text('Resumo Anual de '+ tx_name)

        resumoAnual(id_usuario,nb_ano);
        
      });

      $('#modal_mapa').on('show.bs.modal', function (event) {
        var i;
        for (i = 1; i < 13; i++) {
            $('tbody#entryResumo.'+i).empty();

                    }
         });

         $('.select2-native.slc-anos').on('select2:select', function (event) {
            $('.modal-body').hide();
            $('.progress').show();
            var i;
            for (i = 1; i < 13; i++) {
                $('tbody#entryResumo.'+i).empty();
                        }

            var modal =  $('#modal_mapa')
            var id_usuario = modal.find('input#id_usuario').val()
            var nb_ano = $(this).val()
            resumoAnual(id_usuario,nb_ano);
            
        }); 

});