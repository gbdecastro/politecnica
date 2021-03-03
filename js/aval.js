function situacaoAtual(){

    $.ajax({
        type:'get',
        url: './aval/situacaoAtual'
    }).done(function (response){
        $.each(response, function(i, entry){
            var e = $($('.slc-colaborador')[i])
            e.val(entry.id_f2).trigger("change")
            var e = $($('.slc-nb_nota')[i])
            e.val(entry.nb_nota).trigger("change")
        })
    })  
}

$(function(){

    situacaoAtual();

})