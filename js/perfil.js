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
/******/ 	return __webpack_require__(__webpack_require__.s = 47);
/******/ })
/************************************************************************/
/******/ ({

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

  module.exports = __webpack_require__(48);


  /***/ }),
  
  /***/ 48:
  /***/ (function(module, exports) {
  
  new Vue({
    el: '#projetos',
    created: function created() {
      this.getProjetosFuncionario(0);
    },
    data: {
      projetos_funcionario: [],
      add_projeto_funcionario: {
        id_funcionario: '',
        id_projeto: ''
      },
      errors: []
    },
    methods: {
  
      getProjetosFuncionario: function getProjetosFuncionario(id_funcionario) {
        var _this = this;
  
        /*DESTUIR DATATABLE E ESCONDER A TABELA*/
        $('#table_projetos').DataTable().destroy();
        $('#table_projetos').hide();
        //mostro que estou procurando
        $('.progress').show();
  
        var url = 'funcionario/' + id_funcionario + '/projetos';
  
        axios.get(url).then(function (response) {
  
          //limpo arrray de projetos
          _this.projetos_funcionario = [];
  
          //se nao tiver projetos: carrego pelo menos o id_usuario
          if (response.data == '') {
            _this.projetos_funcionario.push({ "id_funcionario": id_funcionario });
            /*SENAO TIVER DADOS MOSTRAR CALLOUT PRA ISSO*/
            $('#show_projetos_callout').show();
            /*OCULTAR A PROGRESS BAR porque nao achei nada e terminei a pesquisa*/
            $('.progress').hide();
  
            //se tiver projetos, eu pego os projetos dele mesmo.
          } else {
            //pego os projetos
            _this.projetos_funcionario = response.data;
  
            //enquanto isso a progress bar esta ativa
  
            //oculto o callout se estiver ativo por outro projeto
            $('#show_projetos_callout').hide();
          }
          $('#modal_projetos').modal('show');
        }).then(()=>{
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
        var _this2 = this;
  
        var url = 'funcionario/projeto/desativar';
        axios.put(url, projeto_funcionario).then(function (response) {
          _this2.getProjetosFuncionario(projeto_funcionario.id_funcionario);
          toastr.success(projeto_funcionario.tx_projeto + ' desativado com Sucesso');
        });
      },
  
      ativarProjetoFuncionario: function ativarProjetoFuncionario(projeto_funcionario) {
        var _this3 = this;
  
        var url = 'funcionario/projeto/ativar';
        axios.put(url, projeto_funcionario).then(function (response) {
          _this3.getProjetosFuncionario(projeto_funcionario.id_funcionario);
          toastr.success(projeto_funcionario.tx_projeto + ' ativado com Sucesso');
        });
      },
  
      addProjeto: function addProjeto() {
        
        btnSpinAjax($('button[type="submit"]'),$('button[type="submit"]').html());

        var _this4 = this;
  
        var url = 'funcionario/projeto';
  
        this.add_projeto_funcionario.id_funcionario = this.projetos_funcionario[0].id_funcionario;
        this.add_projeto_funcionario.id_projeto = $('#add_id_projeto').val();
        
        axios.post(url, this.add_projeto_funcionario).then(function (response) {
          //atualizo a lista de projetos do funcionario e tambem atualizo a lista de que ele nao faz parte
          _this4.getProjetosFuncionario(_this4.add_projeto_funcionario.id_funcionario);
          _this4.getProjetosNotFuncionario();
          toastr.success('Projeto Vinculado com Sucesso');
          $('#modal_add_projeto').modal('hide');
        });
      },
  
      deleteProjetoFuncionario: function deleteProjetoFuncionario(projeto_funcionario) {
        var _this5 = this;
  
        var url = 'funcionario/projeto/' + projeto_funcionario.id_projeto + '/' + projeto_funcionario.id_grupo + '/' + projeto_funcionario.id_funcionario;
  
        axios.delete(url).then(function (response) {
          if (response.data != '') {
            toastr.error(response.data);
          } else {
            //atualizo os projetos do funcionario
            _this5.getProjetosFuncionario(projeto_funcionario.id_funcionario);
            //e o projetos que ele nao faz parte
            _this5.getProjetosNotFuncionario();
            toastr.success('Projetos Excluídos');
          }
        });
      }
  
    }
  
  });
  
  /***/ })
  
  /******/ });