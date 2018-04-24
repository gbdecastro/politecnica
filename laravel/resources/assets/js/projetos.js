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
};
new Vue({
  el: '#projeto',
  created: function () {
    this.getProjetos();
  },
  data: {
    grupos: [],
    projetos: [],
    new_projeto: {
      tx_projeto: '',
      id_projeto: '',
      id_grupo: '',
      id_empresa: '',
      new_empresa: ''
    },
    edit_projeto: {
      tx_projeto: '',
      id_projeto: '',
      id_grupo: '',
      id_empresa: '',
      new_empresa: ''
    },
    errors: []
  },
  methods: {
    getProjetos: function () {

      $('#table_projetos').DataTable().destroy();
      $('#table_projetos').hide();

      var url = 'vue_projetos';
      toastr.info("Procurando Projetos");
      axios.get(url).then(response => {
        //joga na lista de projetos
        this.projetos = response.data;
        toastr.success("Projetos Encontrados");
      }).then(() => {
        $('#table_projetos').DataTable({
          "order": [],
          "autoWidth": true,
          "oLanguage": {
            "sUrl": "js/datatables_ptbr.json"
          }
        });
        $('.fa-spinner').hide();
        $('#table_projetos').show();
      });
    },
    deleteProjeto: function (projeto) {
      var url = 'projetos/' + projeto.id_projeto + '/' + projeto.id_grupo;

      axios.delete(url)
        .then(response => {
          $('.fa-spinner').show();
          //atualiza a lista de projetos
          this.getProjetos();
          //informo ao usuario
          toastr.success('Projeto ' + projeto.tx_projeto + ' excluído com sucesso');
        }).catch(error => {
          toastr.error(error.response.data.message);
        });

    },
    createProjeto: function () {
      var url = 'projetos';

      var projeto = this.new_projeto;

      projeto.new_empresa = $('#create_projeto_new_empresa').prop('checked');

      projeto.id_empresa = $('#id_empresa').val();
      projeto.id_grupo = $('#id_grupo').val();

      projeto.tx_projeto = projeto.tx_projeto.toUpperCase();

      axios.post(url, projeto)
        .then(response => {
          if (response.data != '') {
            toastr.error(response.data);
          } else {
            toastr.success('Projeto ' + projeto.tx_projeto + ' criado com sucesso');
            $('.fa-spinner').show();
            //atualiza a lista de projetos
            this.getProjetos();
            //limpo lista de erro
            this.errors = [];
            //fecho modal
            $('#modal_create').modal('hide');
            //informo ao usuario
            //limpo formulario
            this.new_projeto = {
              tx_projeto: '',
              id_projeto: '',
              id_grupo: ''
            };
          }

        }).catch(error => {
          toastr.error(error);
        });
    },
    editProjeto: function (projeto) {

      this.edit_projeto.id_projeto = projeto.id_projeto;
      this.edit_projeto.id_grupo = projeto.id_grupo;
      this.edit_projeto.tx_projeto = projeto.tx_projeto.toUpperCase();
      this.edit_projeto.id_empresa = projeto.id_empresa;
      this.edit_projeto.new_empresa = $('#edit_projeto_new_empresa').prop('checked');

      /*PRIMEIRO ALTERO O SELECT SELECTED PARA A EMPRESA*/
      $('#id_empresa_edit').val(this.edit_projeto.id_empresa).trigger('change');

    },
    updateProjeto: function (projeto) {

      var url = 'projetos';

      this.edit_projeto.tx_projeto = this.edit_projeto.tx_projeto.toUpperCase();

      /*marca se é diferente*/
      this.edit_projeto.new_empresa = $('#edit_projeto_new_empresa').prop('checked');

      /*DEPOIS COLOCO NO ID O VALOR REFERENTE AO SELECT*/
      this.edit_projeto.id_empresa = $('#id_empresa_edit').val();

      axios.put(url, this.edit_projeto).then(response => {
        if (response.data != '') {
          toastr.error(response.data);
        } else {
          toastr.success('Projeto ' + this.edit_projeto.tx_projeto + ' editado com sucesso');
          $('fa-spinner').show();
          //atualiza a lista de projetos
          this.getProjetos();
          //atualizar a lista no form_edit
          $('#id_empresa_edit').select2('destroy');
          $('#id_empresa_edit').html('');
          axios.get('empresas').then(response => {
            //atualizando o select de empresas
            $.each(response.data, function (inde, value) {
              $('#id_empresa_edit').append('<option value="' + value.id_empresa + '">' + value.tx_empresa + '</option>');
            });
          });
          $('#id_empresa_edit').select2();
          //limpo o edit
          this.edit_projeto = {
            id_projeto: '',
            id_grupo: '',
            id_empresa: '',
            tx_projeto: ''
          };
          //limpo lista de erro
          this.errors = [];
          //fecho modal
          $('#modal_edit').modal('hide');
          //informo ao usuario
        }
      }).catch(error => {
        toastr.error(error);
      });

    }
  }

});