function situacaoAtual(){

    $.ajax({
        type:'get',
        url: './aval/situacaoAtual'
    }).done(function (response){
        $.each(response, function(i, entry){

            var e = $($('.slc-colaborador')[entry.nb_idx])
            e.val(entry.id_f2).trigger("change")
            var e = $($('.slc-nb_proativ')[entry.nb_idx])
            e.val(entry.nb_proativ).trigger("change")
            var e = $($('.slc-nb_produtiv')[entry.nb_idx])
            e.val(entry.nb_produtiv).trigger("change")
            var e = $($('.slc-nb_pontual')[entry.nb_idx])
            e.val(entry.nb_pontual).trigger("change")

        })
    })  
}

$(function(){

    situacaoAtual();

    $('#modal_mapa').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_usuario = button.data('id-usuario')
        var tx_name = button.data('tx-name')
        var nb_ano = button.data('ano')

        var modal = $(this)
        
        modal.find('input#nb_horas').val(id_usuario)
        modal.find('input#id_lotacao').val(nb_ano)

        modal.find('h4.modal-title').text('Resumo das Avaliações de '+tx_name)

      });

});