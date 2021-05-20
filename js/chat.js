$(function() {  

    $("textarea[maxlength]").on('input propertychange', function() {  
        var maxLength = $(this).attr('maxlength');  
        if ($(this).val().length > maxLength) {  
            $(this).val($(this).val().substr(0, maxLength));  
        }
        
    });

    $("input[maxlength]").on('input propertychange', function() {  
        var maxLength = $(this).attr('maxlength');  
        if ($(this).val().length > maxLength) {  
            $(this).val($(this).val().substr(0, maxLength));  
        }
        
    });

    $('button.nova-enviar').on('click', function(){
        $.ajax({
            type:'post',
            url: './chat/novaMensagem',
            data:{
                tx_titulo: $('input.nova-titulo').val(),
                tx_envio: $('textarea.nova-msg').val()
            }
        }).done(function (response){  
          alert(response[1]);
            if(response[0] == 0){
                location.reload();
            }

        })         
    });

    $('#btn_submit_edit-resposta').on('click', function(){

        $.ajax({
           type:'post',
           url: './chat/responderMensagem',
           data:{
              id_msg: $('input#id_ed-msg').val(),
              tx_resposta: $('textarea.edit-resposta').val()
           }
       }).done(function (response){
         alert(response);
         $('textarea.edit-resposta').val('');
         location.reload();
       })         
   });

   $('button.send-resposta').on('click', function() {
        
        var id_msg = $(this).data('id_msg')
        var tx_resposta = $('input#resposta'+id_msg).val()

        $.ajax({
            type:'post',
            url:'./chat/responderMensagem',
            data:{
                id_msg: id_msg,
                tx_resposta: tx_resposta
            }
        }).done(function (response){
            alert(response);
            location.reload();
          }) 
   });

    $('#modal_respostaMsg').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_msg = button.data('id_msg')
        var resp = $('p#id_resp'+id_msg).text()
        var modal = $(this)        
        
        modal.find('input#id_ed-msg').val(id_msg)
        modal.find('i#resp-original').text(resp)
      })

    $('#modal_removeMsg').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)

        var id_msg = button.data('id_msg')
        var modal = $(this)        
        
        modal.find('input#id_msg').val(id_msg)
      })

    $('#btn_submit_remove').on('click', function(){

         $.ajax({
            type:'post',
            url: './chat/removeMensagem',
            data:{
               id_msg: $('input#id_msg').val()
            }
        }).done(function (response){
          alert(response);
          location.reload();
        })         
    });


});