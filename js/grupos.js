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
/******/ 	return __webpack_require__(__webpack_require__.s = 38);
/******/ })
/************************************************************************/
/******/ ({

/***/ 38:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(39);


/***/ }),

/***/ 39:
/***/ (function(module, exports) {

var app = new Vue({
    el: '#grupo',
    created: function created() {
        this.getGrupos();
    },
    data: {
        grupos: [],
        projetos: [],
        new_grupo: {
            tx_grupo: '',
            tx_color: '',
            cs_situacao: ''
        },
        edit_grupo: {
            id_grupo: '',
            tx_grupo: '',
            tx_color: '',
            cs_situacao: ''
        },
        errors: []
    },
    methods: {
        getGrupos: function getGrupos() {
            var _this = this;

            $('#table_grupos').DataTable().destroy();
            $('#table_grupos').hide();
            var url = 'vue_grupos';
            toastr.info("Procurando Grupos");
            axios.get(url).then(function (response) {
                //joga na lista de grupos
                _this.grupos = response.data;
            }).then(function () {
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
        getProjetos: function getProjetos($id_grupo) {
            var _this2 = this;

            //desturi datatable para fazer novamente
            $('#table_projetos').DataTable().destroy();
            //escondo a tabela ate mostar o resultado
            $('#table_projetos').hide();
            //disparo a progress bar
            $('.progress').show();

            var url = 'projeto/grupo/' + $id_grupo;
            toastr.info("Procurando Projetos do Grupo" + $id_grupo);
            axios.get(url).then(function (response) {
                //joga na lista de grupos
                _this2.projetos = response.data;
                toastr.remove();
            }).then(function () {
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
            });
        },
        // Retirado devivo a reunião com Norberto

        // deleteGrupo: function deleteGrupo(grupo) {
        //     var _this3 = this;

        //     var url = 'grupos/' + grupo.id_grupo;
            
        //     btnSpinAjax($('button[type="submit"]'),$('button[type="submit"]').html());

        //     axios.delete(url).then(function (response) {
        //         $('.fa-spinner').show();
        //         //atualiza a lista de Grupos
        //         _this3.getGrupos();
        //         //informo ao usuario
        //         toastr.success('Grupo ' + grupo.tx_grupo + ' excluído com sucesso');
        //     }).catch(function (error) {
        //         toastr.error(error.response.data.message);
        //     });
        // },

        mudarSituacao: function mudarSituacao(grupo){
            
            var _this3 = this;
            var url = 'grupos/mudarSituacao';

            //mudar para ativo
            if(grupo.cs_situacao == '0'){
                grupo.cs_situacao = '1';
            }else{
                grupo.cs_situacao = '0';
            }

            //btnSpinAjax($('.btn-situacao'),$('.btn-situacao').html());

            axios.post(url,grupo).then(function (response){
                //atualiza a lista de Grupos
                _this3.getGrupos();
                //informo ao usuario
                toastr.success('Situacao do ' + grupo.tx_grupo + ' alterada com Sucesso');                
            }).catch(function (error) {
                toastr.error(error.response.data.message);
            });

        },

        createGrupo: function createGrupo() {
            var _this4 = this;
            
            var url = 'grupos';

            btnSpinAjax($('#btn_submit_create'),$('#btn_submit_create').html());

            var grupo = this.new_grupo;

            grupo.tx_color = $('#new_grupo_color').val();
            grupo.tx_grupo = grupo.tx_grupo.toUpperCase();

            axios.post(url, grupo).then(function (response) {
                $('.fa-spinner').show();
                //atualiza a lista de Grupos
                _this4.getGrupos();
                //limpo lista de erro
                _this4.errors = [];
                //fecho modal
                $('#modal_create').modal('hide');
                //informo ao usuario
                toastr.success('Grupo ' + grupo.tx_grupo + ' criado com sucesso');
                //limpo formulario
                _this4.new_grupo = {
                    tx_grupo: ''
                };
            }).catch(function (error) {
                toastr.error(error);
            });
        },
        editGrupo: function editGrupo(grupo) {
            this.edit_grupo.id_grupo = grupo.id_grupo;
            this.edit_grupo.tx_grupo = grupo.tx_grupo.toUpperCase();
            this.edit_grupo.tx_color = grupo.tx_color;
            $('#edit_grupo_color').val(grupo.tx_color);
        },
        updateGrupo: function updateGrupo(id_grupo) {
            var _this5 = this;
            btnSpinAjax($('#btn_submit_edit'),$('#btn_submit_edit').html());
            var url = 'grupos/' + id_grupo;
            this.edit_grupo.tx_grupo = this.edit_grupo.tx_grupo.toUpperCase();
            this.edit_grupo.tx_color = $('#edit_grupo_color').val();
            axios.put(url, this.edit_grupo).then(function (response) {
                //atualiza a lista de Grupos
                _this5.getGrupos();
                //limpo o edit
                _this5.edit_grupo = {
                    tx_grupo: '',
                    id_grupo: '',
                    tx_color: ''
                };
                //limpo lista de erro
                _this5.errors = [];
                //fecho modal
                $('#modal_edit').modal('hide');
                //informo ao usuario
                toastr.success('Grupo ' + _this5.edit_grupo.tx_grupo + ' editado com sucesso');
                //limpo formulario
                _this5.edit_grupo = {
                    tx_grupo: ''
                };
            }).catch(function (error) {
                toastr.error(error);
            });
        }
    }

});

/***/ })

/******/ });