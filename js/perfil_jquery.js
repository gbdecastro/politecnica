$("#file_profile_image").hide();

$(".foto_perfil").click(function () {
    $("#file_profile_image").trigger('click');
});

$('#file_profile_image').on('change', function () {

    var val = $(this).val();
    $(this).siblings('span').text(val);

    var extension = $(this).val().split('.').pop().toLowerCase();

    if ($.inArray(extension, ['png', 'jpg', 'jpeg', 'tiff', 'bmp']) == -1) {
        alert('Somente imagem no formato *png, *jpg, *jpeg, *tiff, *bmp');
    } else {

        var file_data = $(this).prop('files')[0];


        var form_data = new FormData();
        form_data.append('file', file_data);

        $.ajax({
            url: "perfil/foto", // point to server-side PHP script
            data: form_data,
            type: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false
        }).done(function () {
            $('.foto_perfil').attr('src', $('.foto_perfil').attr('src') + '?' + Math.random());
        });
    }
});

$('#btn_alterar_senha').click(function(){
    $.ajax({
        url: "perfil/alterarSenha",
        data:{
            tx_senha: $('#alterar_senha').val()
        },
        type: 'POST'
    }).done(function () {
        toastr.success('Senha Alterada com Sucesso!');
        $.ajax({
            type: 'POST',
            url: '/logout',
            cache: false,
            success: function()
            {
                window.location = '/painel/calendario';
            }
        });
    });    
});