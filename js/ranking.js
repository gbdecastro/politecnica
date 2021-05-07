function situacaoAtual(){

    $('.progress').show();
$.ajax({
    type:'get',
    url: './ranking/situacaoAtual'
}).done(function (response){
    $.each(response, function(i, entry){

        var e = $('.slc-dpid'+entry.id_usuario)
        e.val(entry.nb_departamento).trigger("change")
        var e = $('.slc-rkid'+entry.id_usuario)
        e.val(entry.nb_ranking).trigger("change")

    })

    $('.progress').hide();
})  
}

$(function(){

situacaoAtual();

$('.valor-hora').on('change', function(e){

    $('.progress').show();
    $.ajax({
        type:'post',
        url: './ranking/mudarNbValor',
        data:{
            id_usuario: $(this).attr("data-id_usuario"),
            nb_custo_hora: parseFloat(this.value).toFixed(2)
        }
    });
    $('.progress').hide();

});

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