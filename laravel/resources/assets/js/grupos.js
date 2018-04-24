//config TOASTR
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "300",
    "extendedTimeOut": "100",
    "timeOut": "2000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
const app = new Vue({
    el: '#grupo',
    created: function () {
        this.getGrupos();
    },
    data: {
        grupos: [],
        projetos: [],
        new_grupo: {
            tx_grupo: '',
            tx_color: ''
        },
        edit_grupo: {
            id_grupo: '',
            tx_grupo: '',
            tx_color: ''
        },
        errors: []
    },
    methods: {
        getGrupos: function () {
            $('#table_grupos').DataTable().destroy();
            $('#table_grupos').hide();
            var url = 'vue_grupos';
            toastr.info("Procurando Grupos");
            axios.get(url).then(response => {
                //joga na lista de grupos
                this.grupos = response.data
            }).then(() => {
                $('#table_grupos').DataTable({
                    "order": [],
                    "autoWidth": true,
                    "oLanguage": {
                        "sUrl": "js/datatables_ptbr.json"
                      }
                });
                $('.fa-spinner').hide();
                $('#table_grupos').show();
                toastr.remove();
                toastr.success("Grupos Encontrados");
            });
        },
        getProjetos: function ($id_grupo) {
            //desturi datatable para fazer novamente
            $('#table_projetos').DataTable().destroy();
            //escondo a tabela ate mostar o resultado
            $('#table_projetos').hide();
            //disparo a progress bar
            $('.progress').show();

            var url = 'projeto/grupo/' + $id_grupo;
            toastr.info("Procurando Projetos do Grupo" + $id_grupo);
            axios.get(url).then(response => {
                //joga na lista de grupos
                this.projetos = response.data;
                toastr.remove();
            }).then(()=>{
                $('#table_projetos').DataTable({
                    "order": [],
                    "autoWidth": true,
                    "oLanguage": {
                        "sUrl": "js/datatables_ptbr.json"
                      }
                });
                $('.progress').hide();
                $('#table_projetos').show();
                toastr.remove();
                toastr.success("Projetos Encontrados");                
            })
        },
        deleteGrupo: function (grupo) {
            var url = 'grupos/' + grupo.id_grupo;

            axios.delete(url)
                .then(response => {
                    $('.fa-spinner').show();
                    //atualiza a lista de Grupos
                    this.getGrupos();
                    //informo ao usuario
                    toastr.success('Grupo ' + grupo.tx_grupo + ' excluído com sucesso');
                }).catch(error => {
                    toastr.error(error.response.data.message);
                });
        },
        createGrupo: function () {

            var url = 'grupos';

            var grupo = this.new_grupo;

            grupo.tx_color = $('#new_grupo_color').val();
            grupo.tx_grupo = grupo.tx_grupo.toUpperCase();

            axios.post(url, grupo)
                .then(response => {
                    $('.fa-spinner').show();
                    //atualiza a lista de Grupos
                    this.getGrupos();
                    //limpo lista de erro
                    this.errors = [];
                    //fecho modal
                    $('#modal_create').modal('hide');
                    //informo ao usuario
                    toastr.success('Grupo ' + grupo.tx_grupo + ' criado com sucesso');
                    //limpo formulario
                    this.new_grupo = {
                        tx_grupo: ''
                    };
                }).catch(error => {
                    toastr.error(error);
                });
        },
        editGrupo: function (grupo) {
            this.edit_grupo.id_grupo = grupo.id_grupo;
            this.edit_grupo.tx_grupo = grupo.tx_grupo.toUpperCase();
            this.edit_grupo.tx_color = grupo.tx_color;
            $('#edit_grupo_color').val(grupo.tx_color);
        },
        updateGrupo: function (id_grupo) {
            var url = 'grupos/' + id_grupo;
            this.edit_grupo.tx_grupo = this.edit_grupo.tx_grupo.toUpperCase();
            this.edit_grupo.tx_color = $('#edit_grupo_color').val();
            axios.put(url, this.edit_grupo)
                .then(response => {
                    //atualiza a lista de Grupos
                    this.getGrupos();
                    //limpo o edit
                    this.edit_grupo = {
                        tx_grupo: '',
                        id_grupo: '',
                        tx_color: ''
                    };
                    //limpo lista de erro
                    this.errors = [];
                    //fecho modal
                    $('#modal_edit').modal('hide');
                    //informo ao usuario
                    toastr.success('Grupo ' + this.edit_grupo.tx_grupo + ' editado com sucesso');
                    //limpo formulario
                    this.edit_grupo = {
                        tx_grupo: ''
                    };
                }).catch(error => {
                    toastr.error(error);
                });

        }
    }

});