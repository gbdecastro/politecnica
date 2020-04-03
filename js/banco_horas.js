$(function(){

    

    $("#tableBancoHoras").DataTable({
        "order": [],
        "autoWidth": true,
        "oLanguage": {
            "sUrl": "../js/datatables_ptbr.json"
        }						
    })

    $('#btn_submit_edit').on('click', function(){
        $.ajax({
            type:'post',
            url: '../banco_horas/mudarBancoHoras',
            data:{
                id_funcionario: $('input#id_funcionario').val(),
                nb_mes1: $('#data_mesAnterior1').val(),
                nb_mes2: $('#data_mesAnterior2').val(),
                nb_mes3: $('#data_mesAnterior3').val(),
                nb_ano1: $('#data_anoAnterior1').val(),
                nb_ano2: $('#data_anoAnterior2').val(),
                nb_ano3: $('#data_anoAnterior3').val(),
                nb_saldo3: $('input#mes3').val(),
                nb_saldo2: $('input#mes2').val(),
                nb_saldo1: $('input#mes1').val()
            }
        }).done(function (response){
            location.reload(true)
        })         
    });

    $('#modal_edit_banco_horas').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_funcionario = button.data('id-funcionario')
        var tx_name = button.data('tx-name')
        var data_mes3 = button.data('mes3')
        var data_mes2 = button.data('mes2')
        var data_mes1 = button.data('mes1')
        var data_mesAnterior3 = button.data('mes-anterior-3')
        var data_mesAnterior2 = button.data('mes-anterior-2')
        var data_mesAnterior1 = button.data('mes-anterior-1')
        var data_anoAnterior3 = button.data('ano-anterior-3')
        var data_anoAnterior2 = button.data('ano-anterior-2')
        var data_anoAnterior1 = button.data('ano-anterior-1')

        var modal = $(this)
        
        modal.find('label.mes3').text(data_mesAnterior3+'/'+data_anoAnterior3)
        modal.find('label.mes2').text(data_mesAnterior2+'/'+data_anoAnterior2)
        modal.find('label.mes1').text(data_mesAnterior1+'/'+data_anoAnterior1)

        modal.find('input#mes3').val(data_mes3)
        modal.find('input#mes2').val(data_mes2)
        modal.find('input#mes1').val(data_mes1)

        modal.find('input#id_funcionario').val(id_funcionario)

        modal.find('input#data_mesAnterior1').val(data_mesAnterior1)
        modal.find('input#data_mesAnterior2').val(data_mesAnterior2)
        modal.find('input#data_mesAnterior3').val(data_mesAnterior3)
        modal.find('input#data_anoAnterior1').val(data_anoAnterior1)
        modal.find('input#data_anoAnterior2').val(data_anoAnterior2)
        modal.find('input#data_anoAnterior3').val(data_anoAnterior3)

        modal.find('h4.modal-title').text('Banco de Horas: '+tx_name)

      })

})