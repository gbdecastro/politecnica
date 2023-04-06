$("#btn_gerar").click(function(){

    dados = {
        ano: $("#dt_ano").val(),
        mes: $("#dt_mes").val()
    }

    $.ajax({
        url: './relatorio/mensal',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_anual").click(function(){

    dados = {
        data_ano: $("#data_ano").val(),
        id_empresa: $("#id_empresa").val()
    }

    $.ajax({
        url: './relatorio/anual',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_projeto_anual").click(function(){

    dados = {
        projeto_ano: $("#projeto_ano").val(),
        id_projeto: $("#id_projeto").val()
    }

    $.ajax({
        url: './relatorio/projeto_anual',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_banco_anual").click(function(){

    dados = {
        colaborador: $("#banco_colaborador").val()
    }

    $.ajax({
        url: './relatorio/banco_anual',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_periodo").click(function(){

    dados = {
        colaborador: $("#colaborador").val(),
        id_empresa: $("#empresa").val(),
        ano_inicio: $("#anoin").val(),
        ano_fim: $("#anoout").val(),
        mes_fim: $("#mesout").val(),
        mes_inicio: $("#mesin").val()

    }

    $.ajax({
        url: './relatorio/periodo',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_debug").click(function(){

    dados = {
        projeto_ano: $("#projeto_ano").val(),
        id_projeto: $("#id_projeto").val()
    }

    $.ajax({
        url: './relatorio/projeto_anual',
        type: 'get',
        data: dados,
        xhrFields: {
            responseType: 'text'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                    console.log(response);
                }
            catch (ex) {
                console.log(ex);
            }
        }
    });
});

$("#btn_gerar_total").click(function(){

    $.ajax({
        url: './relatorio/total',
        type: 'get',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response, status, xhr) {
    
            var filename = "";
            var disposition = xhr.getResponseHeader('Content-Disposition');
    
            if (disposition) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            }
            var linkelem = document.createElement('a');
            try {
                var blob = new Blob([response], {
                    type: 'application/octet-stream'
                });
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);
    
                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
    
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.target = "_blank";
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }
                }
                imprimiuServico = true;
            } catch (ex) {
                console.log(ex);
            }
        }
    });
});