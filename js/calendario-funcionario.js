//functions
//Setando o Mes e Ano Atual nos Selects do Formulario de Pesquisa
function getCurrentDateForFormSeach() {
    var date = new Date();
    month = date.getMonth();
    year = date.getFullYear();

    month++;
    //preciso formatar para o fullcalendar
    if (month <= 9)
        month = "0" + month;

    $("#dt_mes").val(month).trigger("change");
    $("#dt_ano").val(year).trigger("change");
}

//Variavel Utilizadas nao Funcao get Calendario 
var eventos;

//Funcao Geradora do Calendario
function getCalendario(id_funcionario) {

    toastr.info("Procurando dados");

    $('#btn_procurar').prop('disabled', true);

    var mes = $("#dt_mes").val();
    var ano = $("#dt_ano").val();
    var projeto = $('#form_search_projeto').val();
    var initialLangCode = 'pt-br';
    //var situacao = $('#form_search_situacao').val();

    //ajax para carregar o calendario na data com os dados
    $.ajax({
        type: 'GET',
        url: 'funcionarios/calendario/' + ano + '/' + mes + '/' + projeto + '/' + id_funcionario,
        dataType: 'json',
    }).done(function (data) {
        toastr.remove();
        eventos = [];
        $.each(data, function (i, entry) {
            eventos.push({
                id: entry.id_funcionario,
                color: entry.tx_color,
                id_projeto: entry.id_projeto,
                tx_projeto: entry.tx_projeto,
                nb_despesa: entry.nb_despesa,
                title: entry.id_projeto + ' - ' + entry.nb_horas_trabalho + ' hrs',
                start: entry.dt_trabalho,
                nb_horas_trabalho: entry.nb_horas_trabalho,
                description: entry.tx_projeto + ' ' + entry.nb_horas_trabalho
            });
        });

        $('#calendario').fullCalendar('destroy');

        $('#calendario').fullCalendar({
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultDate: ano + '-' + mes,
            lang: initialLangCode,
            editable: false,
            events: eventos,
            height: 600,
            showNonCurrentDates: false
        });

        $('#calendario').fullCalendar('gotoDate', ano + '-' + mes);

        $('#btn_procurar').prop('disabled', false);

        toastr.success("Dados Encontrados");
    });
    
    toastr.remove();
}

//anos Trabalhados
function init(id_funcionario){
    $.ajax({
        type: 'GET',
        url: 'funcionarios/calendario/projetos/ano/trabalhados/'+id_funcionario,
        dataType: "json"
    }).done(function (data) {
        i = data[0];
        j = data[1];
        for (i; i <= j; i++) {
            $('#dt_ano').append('<option value=' + i + '>' + i + '</option>');
        }
        /*
        setando nos select do form de pesquisa
        os projetos do usuario
        */
        $.ajax({
            type: 'GET',
            url: 'funcionarios/calendario/projetos/'+id_funcionario,
            dataType: "json",
        }).done(function (data) {
    
            $.each(data, function (i, entry) {
                var option = '<option value=' + entry.id_projeto + '>' + entry.id_projeto + '-' + entry.tx_projeto + '</option>';
                $('#form_search_projeto').append(option);
            });
    
        });

        getCurrentDateForFormSeach(id_funcionario);
        getCalendario(id_funcionario);
        //getResumo($('#form_search_projeto').val());
    });
        
}

//Preencher Selects do Formulario de Pesquisa
//No Done fica a inicializacao do Calendario
$('#modal_calendario').on('show.bs.modal', function (event) {
    var el = $(event.relatedTarget)
    var id_funcionario = el.data('id_funcionario')
    init(id_funcionario);
});

//Botao Procurar da Box Formulario de Pesquisa
$('#btn_procurar').click(function () {
    getCalendario();
    //getResumo($('#form_search_projeto').val());
    btnSpinAjax($(this), $(this).html());
});