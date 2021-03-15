function situacaoAtual(){
        //$('#tableAval').hide();
        $('.progress').show();
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
        $('.progress').hide();
       // $('#tableAval').show();
    })  
}

$(function(){

    situacaoAtual();

    $('.select2-native.slc-colaborador').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: './aval/mudarColaborador',
            data:{
                former: $(this).attr("data-former"),
                id_f2: $(this).val()
            }
        }).done(function(){
            situacaoAtual();
        })
    }); 

    $('.select2-native.slc-nb_proativ').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: './aval/mudarProativ',
            data:{
                former: $(this).attr("data-former"),
                nb_proativ: $(this).val()
            }
        }).done(function(){
            situacaoAtual();
        })
    }); 

    $('.select2-native.slc-nb_produtiv').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: './aval/mudarProdutiv',
            data:{
                former: $(this).attr("data-former"),
                nb_produtiv: $(this).val()
            }
        }).done(function(){
            situacaoAtual();
        })
    }); 

    $('.select2-native.slc-nb_pontual').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: './aval/mudarPontual',
            data:{
                former: $(this).attr("data-former"),
                nb_pontual: $(this).val()
            }
        }).done(function(){
            situacaoAtual();
        })
    }); 

});