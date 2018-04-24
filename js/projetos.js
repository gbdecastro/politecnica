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
/******/ 	return __webpack_require__(__webpack_require__.s = 40);
/******/ })
/************************************************************************/
/******/ ({

/***/ 40:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(41);


/***/ }),

/***/ 41:
/***/ (function(module, exports) {

new Vue({
  el: '#projeto',
  created: function created() {
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
      cs_situacao: '',
      new_empresa: '',
      cs_status: ''
    },
    edit_projeto: {
      tx_projeto: '',
      id_projeto: '',
      id_grupo: '',
      id_empresa: '',
      cs_situacao: '',
      new_empresa: '',
      cs_status: ''      
    },
    errors: []
  },
  methods: {
    getProjetos: function getProjetos() {
      var _this = this;

      $('#table_projetos').DataTable().destroy();
      $('#table_projetos').hide();

      var url = 'vue_projetos';
      
      toastr.info("Procurando Projetos");
      axios.get(url).then(function (response) {
        //joga na lista de projetos
        _this.projetos = response.data;
        toastr.success("Projetos Encontrados");
      }).then(function () {
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
    // Retirado conforme Reunião com Norberto
    // deleteProjeto: function deleteProjeto(projeto) {
    //   var _this2 = this;

    //   var url = 'projetos/' + projeto.id_projeto + '/' + projeto.id_grupo;

    //   btnSpinAjax($('button[type="submit"]'),$('button[type="submit"]').html());

    //   axios.delete(url).then(function (response) {
    //     $('.fa-spinner').show();
    //     //atualiza a lista de projetos
    //     _this2.getProjetos();
    //     //informo ao usuario
    //     toastr.success('Projeto ' + projeto.tx_projeto + ' excluído com sucesso');
    //   }).catch(function (error) {
    //     toastr.error(error.response.data.message);
    //   });
    // },
    mudarSituacao: function mudarSituacao(projeto){
      var _this2 = this;
      var url = 'projetos/mudarSituacao';

      //ativar
      if(projeto.cs_situacao == '0')
        projeto.cs_situacao = '1';
      else
        projeto.cs_situacao = '0';

      //btnSpinAjax($('.btn-situacao'),$('.btn-situacao').html());

      axios.post(url,projeto).then(function (response){
        _this2.getProjetos();
        toastr.success('Alterado a Situacao do Projeto '+projeto.tx_projeto);
      }).catch(function (error) {
        toastr.error(error);
      });

    },
    createProjeto: function createProjeto() {
      var _this3 = this;

      var url = 'projetos';

      var projeto = this.new_projeto;

      projeto.new_empresa = $('#create_projeto_new_empresa').prop('checked');

      projeto.id_empresa = $('#id_empresa').val();
      projeto.id_grupo = $('#id_grupo').val();
      projeto.cs_status = $('#cs_status').val();

      projeto.tx_projeto = projeto.tx_projeto.toUpperCase();

      if(projeto.tx_projeto == '' || projeto.id_projeto == ''){
        toastr.error("Preencher Campo Obrigatório"); 
        return false;
      }else{

        btnSpinAjax($('button[type="submit"]'),$('button[type="submit"]').html());

        axios.post(url, projeto).then(function (response) {
          if (response.data != '') {
            toastr.error(response.data);
          } else {
            toastr.success('Projeto ' + projeto.tx_projeto + ' criado com sucesso');
            $('.fa-spinner').show();
            //atualiza a lista de projetos
            _this3.getProjetos();
            //limpo lista de erro
            _this3.errors = [];
            //fecho modal
            $('#modal_create').modal('hide');
            //informo ao usuario
            //limpo formulario
            _this3.new_projeto = {
              tx_projeto: '',
              id_projeto: '',
              id_grupo: ''
            };
          }
        }).catch(function (error) {
          toastr.error(error);
        });        
      }
    },
    editProjeto: function editProjeto(projeto) {

      this.edit_projeto.id_projeto = projeto.id_projeto;
      this.edit_projeto.id_grupo = projeto.id_grupo;
      this.edit_projeto.tx_grupo = projeto.tx_grupo;
      this.edit_projeto.tx_projeto = projeto.tx_projeto.toUpperCase();
      this.edit_projeto.cs_status = projeto.cs_status;

      if(projeto.tx_projeto == ''){
        toastr.error("Preencher Campo Obrigatório");
        return false;        
      }      

      this.edit_projeto.id_empresa = projeto.id_empresa;
      this.edit_projeto.new_empresa = $('#edit_projeto_new_empresa').prop('checked');

      /*PRIMEIRO ALTERO O SELECT SELECTED PARA A EMPRESA*/
      $('#id_empresa_edit').val(this.edit_projeto.id_empresa).trigger('change');
      $('#cs_status_edit').val(this.edit_projeto.cs_status).trigger('change');
    },
    updateProjeto: function updateProjeto(projeto) {
      var _this4 = this;

      var url = 'projetos';

      btnSpinAjax($('#btn_editar_form'),$('#btn_editar_form').html());

      this.edit_projeto.tx_projeto = this.edit_projeto.tx_projeto.toUpperCase();

      /*marca se é diferente*/
      this.edit_projeto.new_empresa = $('#edit_projeto_new_empresa').prop('checked');

      /*DEPOIS COLOCO NO ID O VALOR REFERENTE AO SELECT*/
      this.edit_projeto.id_empresa = $('#id_empresa_edit').val();

      this.edit_projeto.cs_status = $('#cs_status_edit').val();

      axios.put(url, this.edit_projeto).then(function (response) {
        if (response.data != '') {
          toastr.error(response.data);
        } else {
          toastr.success('Projeto ' + _this4.edit_projeto.tx_projeto + ' editado com sucesso');
          $('fa-spinner').show();
          //atualiza a lista de projetos
          _this4.getProjetos();
          //atualizar a lista no form_edit
          $('#id_empresa_edit').select2('destroy');
          $('#id_empresa_edit').html('');
          axios.get('empresas').then(function (response) {
            //atualizando o select de empresas
            $.each(response.data, function (inde, value) {
              $('#id_empresa_edit').append('<option value="' + value.id_empresa + '">' + value.tx_empresa + '</option>');
            });
          });
          $('#id_empresa_edit').select2();
          //limpo o edit
          _this4.edit_projeto = {
            id_projeto: '',
            id_grupo: '',
            id_empresa: '',
            tx_projeto: ''
          };
          //limpo lista de erro
          _this4.errors = [];
          //fecho modal
          $('#modal_edit').modal('hide');
          //informo ao usuario
        }
      }).catch(function (error) {
        toastr.error(error);
      });
    }
  }

});

/***/ })

/******/ });