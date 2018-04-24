NProgress.start();

$(document).ajaxStart(function() {
    window.ajaxBusy = true;
    NProgress.start();

});

$(document).ajaxStop(function() {
    window.ajaxBusy = false;

    NProgress.done();
});

$(document).ajaxError(function() {
    window.ajaxBusy = false;
    NProgress.done();
});

window.onload = function () {
    NProgress.done(); 
}

//select2
$('.select2-native').select2({
    width: '100%',
    allowClear: true    
});

//select2 tag
$('.select2-tag').select2({
    width: '100%',
    allowClear: true,
    tags: true
}); 

//ajax setup for laravel
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//funcao para botao
function btnSpinAjax (btn,content){
    btn.prop('disabled',true);
    btn.html('<i class="fa fa-spinner fa-spin"></i>'+content);
    $(document).ajaxStop(function() {
        window.ajaxBusy = false;
        btn.html(content);
        btn.prop('disabled',false);
    });
    
    $(document).ajaxError(function() {
        window.ajaxBusy = false;
        btn.html(content);
        btn.prop('disabled',false);
    });    
}