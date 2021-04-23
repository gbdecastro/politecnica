function situacaoAtual(){

$.ajax({
    type:'get',
    url: './ranking/situacaoAtual'
}).done(function (response){
    $.each(response, function(i, entry){

        var e = $('#'+entry.id_usuario+'.slc-nb_departamento')
        e.val(entry.nb_departamento).trigger("change")
        var e = $('#'+entry.id_usuario+'.slc-nb_ranking')
        e.val(entry.nb_ranking).trigger("change")

    })

})  
}

$(function(){

situacaoAtual();

$('.select2-native.slc-nb_departamento').on('select2:select', function (e) {
    $.ajax({
        type:'post',
        url: './ranking/mudarDepartamento',
        data:{
            id_usuario: $(this).attr("data-id_usuario"),
            nb_departamento: $(this).val()
        }
    }).done(function(){
        situacaoAtual();
    })
}); 

$('.select2-native.slc-nb_ranking').on('select2:select', function (e) {
    $.ajax({
        type:'post',
        url: './ranking/mudarRanking',
        data:{
            id_usuario: $(this).attr("data-id_usuario"),
            nb_ranking: $(this).val()
        }
    }).done(function(){
        situacaoAtual();
    })
}); 

});