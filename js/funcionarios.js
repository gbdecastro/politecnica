/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ }),

/***/ 43:
/***/ (function(module, exports) {
new Vue({
  el: '#funcionario',
  created: function created() {
    this.getFuncionarios();
  },
  data: {
    funcionarios: [],
    new_funcionario: {
      tx_name: '',
      tx_email: '',
      tx_password: '',
      tx_funcao: '',
      dt_admissao: '',
      tx_password_confirmation: '',
      nb_category_user: '',
      nb_nota: '',
    },
    edit_funcionario: {
      id_usuario: '',
      tx_name: '',
      tx_email: '',
      tx_password: '',
      tx_funcao: '',
      dt_admissao: '',
      tx_password_confirmation: '',
      nb_category_user: '',
      nb_nota: '',
    },
    projetos_funcionario: [],
    add_projeto_funcionario: {
      id_funcionario: '',
      id_projeto: ''
    },
    errors: []
  },
  methods: {

    getFuncionarios: function getFuncionarios() {
      var _this = this;

      $('#table_funcionarios').DataTable().destroy();
      $('#table_funcionarios').hide();

      var url = 'vue_funcionarios';
      toastr.info("Procurando Funcionários");
      axios.get(url).then(function (response) {

        //formatando as datas
        $.each(response.data, function (inde, value) {
          var d = new Date(value.created_at);
          value.created_at = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
        });

        //joga na lista de funcionarios
        _this.funcionarios = response.data;

        toastr.success("Funcionários Encontrados");
      }).then(function () {
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

    createFuncionario: function createFuncionario() {
      var _this2 = this;

      var url = 'funcionarios';

      var funcionario = this.new_funcionario;

      funcionario.nb_category_user = $('#new_funcionario_categoria').val();

      funcionario.tx_name = funcionario.tx_name.toUpperCase();

      if(funcionario.tx_name == '' || funcionario.tx_email == '' ||  funcionario.tx_password == '' || funcionario.tx_password_confirmation == ''){
        toastr.error("Preencher Campos Obrigatórios");
        return false;
      }else{
        if (funcionario.tx_password == funcionario.tx_password_confirmation) {

          btnSpinAjax($('#btn_submit_register'),$('#btn_submit_register').html());

          axios.post(url, funcionario).then(function (response) {
            $('.fa-spinner').show();
            //atualizo a lista
            _this2.getFuncionarios();
  
            /*limpo erros*/
            $('.help-block').remove();
            $('#tx_password_confirmation').removeClass('has-error');
            _this2.error = [];
  
            $('#modal_create').modal('hide');
  
            toastr.success('Usuário: ' + funcionario.tx_name + ' criado com Sucesso');
          }).catch(function (error) {
            toastr.error(error);
          });
        } else {
          toastr.error('As Senhas não conferem');
          $('#tx_password_confirmation').addClass('has-error');
          $('#tx_password_confirmation').append('<span class="help-block"><strong>Senhas não conferem</strong></span>');
        }
      }
    },

    editFuncionario: function editFuncionario(funcionario) {
      this.edit_funcionario.id_usuario = funcionario.id_usuario;
      this.edit_funcionario.tx_name = funcionario.tx_name;
      this.edit_funcionario.tx_email = funcionario.tx_email;
      this.edit_funcionario.tx_funcao = funcionario.tx_funcao;
      this.edit_funcionario.dt_admissao = funcionario.dt_admissao;
      this.edit_funcionario.nb_nota = funcionario.nb_nota;

      this.edit_funcionario.nb_category_user = funcionario.nb_category_user == 'Administrador' ? 1 : 0;

      if(funcionario.tx_name == '' || funcionario.tx_email == '' || funcionario.dt_admissao == ''){
        toastr.error("Preencher Campos Obrigatórios");
        return false;
      }     

      $('#edit_funcionario_categoria').val(this.edit_funcionario.nb_category_user).trigger('change');
    },

    updateFuncionario: function updateFuncionario(funcionario) {
      var _this3 = this;

      var url = 'funcionarios';

      var funcionario = this.edit_funcionario;

      btnSpinAjax($('#btn_submit_edit'),$('#btn_submit_edit').html());

      funcionario.nb_category_user = $('#edit_funcionario_categoria').val();

      funcionario.tx_name = funcionario.tx_name.toUpperCase();

      axios.put(url, funcionario).then(function (response) {

        $('.fa-spinner').show();
        //atualizo a lista
        _this3.getFuncionarios();

        $('#modal_edit').modal('hide');

        toastr.success('Usuário: ' + funcionario.tx_name + ' editado com Sucesso');
      }).catch(function (error) {
        toastr.error(error);
      });
    },

    deleteProjetoFuncionario: function deleteProjetoFuncionario(projeto_funcionario) {
      var _this4 = this;

      var url = 'funcionario/projeto/' + projeto_funcionario.id_projeto + '/' + projeto_funcionario.id_grupo + '/' + projeto_funcionario.id_funcionario;

      btnSpinAjax($('button[type="submit"]'),$('button[type="submit"]').html());

      axios.delete(url).then(function (response) {
        if (response.data != '') {
          toastr.error(response.data);
        } else {
          //atualizo os projetos do funcionario
          _this4.getProjetosFuncionario(projeto_funcionario.id_funcionario);
          //e o projetos que ele nao faz parte
          _this4.getProjetosNotFuncionario();
          toastr.success('Projetos Excluídos');
        }
      });
    },

    getProjetosFuncionario: function getProjetosFuncionario(id_funcionario) {
      var _this5 = this;

      /*DESTUIR DATATABLE E ESCONDER A TABELA*/
      $('#table_projetos').DataTable().destroy();
      $('#table_projetos').hide();
      //mostro que estou procurando
      $('.progress').show();
      var result = null;
      var url = 'funcionario/' + id_funcionario + '/projetos';
      axios.get(url).then(function (response) {

        //limpo arrray de projetos
        _this5.projetos_funcionario = [];

        //se nao tiver projetos: carrego pelo menos o id_usuario
        if (response.data == '') {
          _this5.projetos_funcionario.push({
            "id_funcionario": id_funcionario
          });
          /*SENAO TIVER DADOS MOSTRAR CALLOUT PRA ISSO*/
          $('#show_projetos_callout').show();
          /*OCULTAR A PROGRESS BAR porque nao achei nada e terminei a pesquisa*/
        } else {
          //pego os projetos
          _this5.projetos_funcionario = response.data;
          //enquanto isso a progress bar esta ativa
          result = 1;
          //oculto o callout se estiver ativo por outro projeto
          $('#show_projetos_callout').hide();
        }
        $('#modal_projetos').modal('show');
      }).then(function () {
        if(result == 1){
          $('#table_projetos').DataTable({
            "order": [],
            "oLanguage": {
              "sUrl": "js/datatables_ptbr.json"
            }
          });

          $('.table_show_projetos').show();

        }else{
          $('.table_show_projetos').hide();
        }
        //oculto a progress porque achei os dados  
        $('.progress').hide();
        //e enfim mostro os dados na tabela
        $('#table_projetos').show();
      });
    },

    getProjetosNotFuncionario: function getProjetosNotFuncionario() {

      /*procuro de acordo com o id*/
      var url = 'funcionario/' + this.projetos_funcionario[0].id_funcionario + '/not/projetos';

      axios.get(url).then(function (response) {
        response = response.data;

        if (response == '') {
          $('#modal_add_projeto').modal('hide');
          toastr.warning('Funcionario possui todos os projetos');
        } else {
          /*limpo o select de projetos da view add_projeto*/
          $('#add_id_projeto').html('');
          /*preencho com cada dado retornado*/
          for (var i = 0; i < response.length; i++) {
            //NOVA FORMA DE COLORCAR OPTION
            $('#add_id_projeto').append(new Option(response[i].id_projeto + ' - ' + response[i].tx_projeto, response[i].id_projeto, true, true));
          }
        }
        }).then(function(){
          $('#add_id_projeto').select2({
            width: '100%',
            allowClear: true             
          });
        });
      
    },

    desativarProjetoFuncionario: function desativarProjetoFuncionario(projeto_funcionario) {
      var _this6 = this;

      var url = 'funcionario/projeto/desativar';
      axios.put(url, projeto_funcionario).then(function (response) {
        _this6.getProjetosFuncionario(projeto_funcionario.id_funcionario);
        toastr.success(projeto_funcionario.tx_projeto + ' desativado com Sucesso');
      });
    },

    ativarProjetoFuncionario: function ativarProjetoFuncionario(projeto_funcionario) {
      var _this7 = this;

      var url = 'funcionario/projeto/ativar';
      axios.put(url, projeto_funcionario).then(function (response) {
        _this7.getProjetosFuncionario(projeto_funcionario.id_funcionario);
        toastr.success(projeto_funcionario.tx_projeto + ' ativado com Sucesso');
      });
    },

    addProjeto: function addProjeto() {
      var _this8 = this;

      var url = 'funcionario/projeto';

      btnSpinAjax($('#btn_submit_add'),$('#btn_submit_add').html());

      this.add_projeto_funcionario.id_funcionario = this.projetos_funcionario[0].id_funcionario;
      this.add_projeto_funcionario.id_projeto = $('#add_id_projeto').val();

      axios.post(url, this.add_projeto_funcionario).then(function (response) {
        //atualizo a lista de projetos do funcionario e tambem atualizo a lista de que ele nao faz parte
        _this8.getProjetosFuncionario(_this8.add_projeto_funcionario.id_funcionario);
        _this8.getProjetosNotFuncionario();
        toastr.success('Projeto Vinculado com Sucesso');
        $('#modal_add_projeto').modal('hide');
      });
    }

  }

});

/***/ })

/******/ });