//config TOASTR
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
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
  el: '#funcionario',
  created: function () {
    this.getFuncionarios();
  },
  data: {
    funcionarios: [],
    new_funcionario: {
      tx_name: '',
      tx_email: '',
      tx_password: '',
      tx_password_confirmation: '',
      nb_category_user: ''
    },
    edit_funcionario: {
      id_usuario: '',
      tx_name: '',
      tx_email: '',
      tx_password: '',
      tx_password_confirmation: '',
      nb_category_user: ''
    },
    projetos_funcionario: [],
    add_projeto_funcionario: {
      id_funcionario: '',
      id_projeto: ''
    },
    errors: []
  },
  methods: {

    getFuncionarios: function () {

      $('#table_funcionarios').DataTable().destroy();
      $('#table_funcionarios').hide();

      var url = 'vue_funcionarios';
      toastr.info("Procurando Funcionários");
      axios.get(url).then(response => {

        //formatando as datas
        $.each(response.data, function (inde, value) {
          var d = new Date(value.created_at);
          value.created_at = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
        });

        //joga na lista de funcionarios
        this.funcionarios = response.data;

        toastr.success("Funcionários Encontrados");
      }).then(() => {
        //done
        $('#table_funcionarios').DataTable({
          "order": [],
          "autoWidth": true,
          "oLanguage": {
            "sUrl": "js/datatables_ptbr.json"
          }
        });
        $('.fa-spinner').hide();
        $('#show_projetos_callout').hide();
        $('#table_funcionarios').show();
      });
    },

    createFuncionario: function () {

      var url = 'funcionarios';

      var funcionario = this.new_funcionario;

      funcionario.nb_category_user = $('#new_funcionario_categoria').val();

      funcionario.tx_name = funcionario.tx_name.toUpperCase();

      if (funcionario.tx_password == funcionario.tx_password_confirmation) {

        axios.post(url, funcionario).then(response => {
          $('.fa-spinner').show();
          //atualizo a lista
          this.getFuncionarios();

          /*limpo erros*/
          $('.help-block').remove();
          $('#tx_password_confirmation').removeClass('has-error');
          this.error = [];

          $('#modal_create').modal('hide');

          toastr.success('Usuário: ' + funcionario.tx_name + ' criado com Sucesso');

        }).catch(error => {
          toastr.error(error);
        });
      } else {
        toastr.error('As Senhas não conferem');
        $('#tx_password_confirmation').addClass('has-error');
        $('#tx_password_confirmation').append('<span class="help-block"><strong>Senhas não conferem</strong></span>');
      }
    },

    editFuncionario: function (funcionario) {
      this.edit_funcionario.id_usuario = funcionario.id_usuario;
      this.edit_funcionario.tx_name = funcionario.tx_name;
      this.edit_funcionario.tx_email = funcionario.tx_email;
      if (funcionario.nb_category_user == 'Funcionário') {
        this.edit_funcionario.nb_category_user = 0;
      } else {
        this.edit_funcionario.nb_category_user = 1;
      }
      $('#edit_funcionario_categoria').val(this.edit_funcionario.nb_category_user).trigger('change');
    },

    updateFuncionario: function (funcionario) {

      var url = 'funcionarios';

      var funcionario = this.edit_funcionario;

      funcionario.nb_category_user = $('#edit_funcionario_categoria').val();

      funcionario.tx_name = funcionario.tx_name.toUpperCase();

      axios.put(url, funcionario).then(response => {

        $('.fa-spinner').show();
        //atualizo a lista
        this.getFuncionarios();

        $('#modal_edit').modal('hide');

        toastr.success('Usuário: ' + funcionario.tx_name + ' editado com Sucesso');
      }).catch(error => {
        toastr.error(error);
      });

    },

    deleteProjetoFuncionario: function (projeto_funcionario) {

      var url = 'funcionario/projeto/' + projeto_funcionario.id_projeto + '/' + projeto_funcionario.id_grupo + '/' + projeto_funcionario.id_funcionario;

      axios.delete(url).then(response => {
        if (response.data != '') {
          toastr.error(response.data);
        } else {
          //atualizo os projetos do funcionario
          this.getProjetosFuncionario(projeto_funcionario.id_funcionario);
          //e o projetos que ele nao faz parte
          this.getProjetosNotFuncionario();
          toastr.success('Projetos Excluídos');
        }
      });

    },

    getProjetosFuncionario: function (id_funcionario) {
      /*DESTUIR DATATABLE E ESCONDER A TABELA*/
      $('#table_projetos').DataTable().destroy();
      $('#table_projetos').hide();
      //mostro que estou procurando
      $('.progress').show();

      var url = 'funcionario/' + id_funcionario + '/projetos';
      axios.get(url).then(response => {

        //limpo arrray de projetos
        this.projetos_funcionario = [];

        //se nao tiver projetos: carrego pelo menos o id_usuario
        if (response.data == '') {
          this.projetos_funcionario.push({
            "id_funcionario": id_funcionario
          });
          /*SENAO TIVER DADOS MOSTRAR CALLOUT PRA ISSO*/
          $('#show_projetos_callout').show();
          /*OCULTAR A PROGRESS BAR porque nao achei nada e terminei a pesquisa*/
          $('.progress').hide();

          //se tiver projetos, eu pego os projetos dele mesmo.
        } else {
          //pego os projetos
          this.projetos_funcionario = response.data;

          //enquanto isso a progress bar esta ativa

          //oculto o callout se estiver ativo por outro projeto
          $('#show_projetos_callout').hide();

        }
        $('#modal_projetos').modal('show');
      }).then(() => {
        $('#table_projetos').DataTable({
          "order": [],
          "oLanguage": {
            "sUrl": "js/datatables_ptbr.json"
          }
        });
        //oculto a progress porque achei os dados  
        $('.progress').hide();
        //e enfim mostro os dados na tabela
        $('#table_projetos').show();
      });
    },

    getProjetosNotFuncionario: function () {

      /*procuro de acordo com o id*/
      var url = 'funcionario/' + this.projetos_funcionario[0].id_funcionario + '/not/projetos';

      axios.get(url).then(response => {
        response = response.data;

        if (response == '') {
          $('#modal_add_projeto').modal('hide');
          toastr.warning('Funcionario possui todos os projetos');
        } else {
          /*limpo o select de projetos da view add_projeto*/
          $('#add_id_projeto').html('');
          /*preencho com cada dado retornado*/
          for (var i = 0; i < response.length; i++) {
            $('#add_id_projeto').append('<option value="' + response[i].id_projeto + '">' + response[i].id_projeto + ' - ' + response[i].tx_projeto + '</option>');
          }
        }
      });

    },

    desativarProjetoFuncionario: function (projeto_funcionario) {
      var url = 'funcionario/projeto/desativar';
      axios.put(url, projeto_funcionario).then(response => {
        this.getProjetosFuncionario(projeto_funcionario.id_funcionario)
        toastr.success(projeto_funcionario.tx_projeto + ' desativado com Sucesso');
      });
    },

    ativarProjetoFuncionario: function (projeto_funcionario) {
      var url = 'funcionario/projeto/ativar';
      axios.put(url, projeto_funcionario).then(response => {
        this.getProjetosFuncionario(projeto_funcionario.id_funcionario);
        toastr.success(projeto_funcionario.tx_projeto + ' ativado com Sucesso');
      });
    },

    addProjeto: function () {

      var url = 'funcionario/projeto';

      this.add_projeto_funcionario.id_funcionario = this.projetos_funcionario[0].id_funcionario;
      this.add_projeto_funcionario.id_projeto = $('#add_id_projeto').val();

      axios.post(url, this.add_projeto_funcionario).then(response => {
        //atualizo a lista de projetos do funcionario e tambem atualizo a lista de que ele nao faz parte
        this.getProjetosFuncionario(this.add_projeto_funcionario.id_funcionario);
        this.getProjetosNotFuncionario();
        toastr.success('Projeto Vinculado com Sucesso');
        $('#modal_add_projeto').modal('hide');
      });
    }

  }

});