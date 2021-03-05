function situacaoAtual(){

    $.ajax({
        type:'get',
        url: './aval/situacaoAtual'
    }).done(function (response){
        $.each(response, function(i, entry){
            var e = $($('.slc-colaborador')[i])
            e.val(entry.id_f2).trigger("change")
            var e = $($('.slc-nb_proativ')[i])
            e.val(entry.nb_proativ).trigger("change")
            var e = $($('.slc-nb_produtiv')[i])
            e.val(entry.nb_produtiv).trigger("change")
            var e = $($('.slc-nb_pontual')[i])
            e.val(entry.nb_pontual).trigger("change")
        })
    })  
}

$(function(){

    situacaoAtual();

})