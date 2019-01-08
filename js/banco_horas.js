function dias_uteis(){

    $.ajax({
        type:'get',
        url: '../banco_horas/dias_uteis'
    }).done(function (response){
        $.each(response, function(i, entry){
            var e = $($('.slc-dias-uteis')[i])
            e.val(entry.nb_dias).trigger("change")
        })
    })  
}

$(function(){

    dias_uteis()

    $("#tableBancoHoras").DataTable({
        "order": [],
        "autoWidth": true,
        "oLanguage": {
            "sUrl": "../js/datatables_ptbr.json"
        }						
    })

    $('.select2-native').on('select2:select', function (e) {
        $.ajax({
            type:'post',
            url: '../banco_horas/mudar_dias_uteis',
            data:{
                nb_mes: $(this).attr("data"),
                nb_dias: $(this).val()
            }
        }).done(function(){
            dias_uteis()
        })
    }); 
})