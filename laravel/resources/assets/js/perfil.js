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
    el: '#projetos',
    created: function(){
      this.getProjetosFuncionario(0);
    },
    data: {
      projetos_funcionario: [],
      add_projeto_funcionario:{
        id_funcionario: '',
        id_projeto: ''
      },
      errors: []
    },
    methods:{

      getProjetosFuncionario: function(id_funcionario){

        /*DESTUIR DATATABLE E ESCONDER A TABELA*/
        $('#table_projetos').DataTable().destroy();
        $('#table_projetos').hide();
        //mostro que estou procurando
        $('.progress').show();

        var url = '/funcionario/'+id_funcionario+'/projetos';

        axios.get(url).then(response =>{
          
          //limpo arrray de projetos
          this.projetos_funcionario = [];

          //se nao tiver projetos: carrego pelo menos o id_usuario
          if(response.data == ''){
            this.projetos_funcionario.push({"id_funcionario":id_funcionario});
            /*SENAO TIVER DADOS MOSTRAR CALLOUT PRA ISSO*/
            $('#show_projetos_callout').show();
            /*OCULTAR A PROGRESS BAR porque nao achei nada e terminei a pesquisa*/
            $('.progress').hide();

          //se tiver projetos, eu pego os projetos dele mesmo.
          }else{
            //pego os projetos
            this.projetos_funcionario = response.data;
            
            //enquanto isso a progress bar esta ativa

            //oculto o callout se estiver ativo por outro projeto
            $('#show_projetos_callout').hide();

            //apos a pesquisa:
            setTimeout(function() {
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
            }, 2000);             
          }
          $('#modal_projetos').modal('show');
        });
      },

      getProjetosNotFuncionario: function(){
        /*procuro de acordo com o id*/  
        var url = '/funcionario/'+this.projetos_funcionario[0].id_funcionario+'/not/projetos';
        axios.get(url).then(response =>{
          response = response.data;
          if(response == ''){
            $('#modal_add_projeto').modal('hide');
            toastr.warning('Funcionario possui todos os projetos');
          }else{
            /*limpo o select de projetos da view add_projeto*/
            $('#add_id_projeto').html('');
            /*preencho com cada dado retornado*/
            for (var i = 0; i < response.length; i++){
              //NOVA FORMA DE COLORCAR OPTION
              $('#add_id_projeto').append(new Option(response[i].id_projeto+' - '+response[i].tx_projeto,response[i].id_projeto,true,true));
            } 
          }     
        });
      },

      desativarProjetoFuncionario: function(projeto_funcionario){
        var url = '/funcionario/projeto/desativar';
        axios.put(url,projeto_funcionario).then(response =>{
          this.getProjetosFuncionario(projeto_funcionario.id_funcionario)
          toastr.success(projeto_funcionario.tx_projeto+' desativado com Sucesso');
        });
      },

      ativarProjetoFuncionario: function(projeto_funcionario){
        var url = '/funcionario/projeto/ativar';
        axios.put(url,projeto_funcionario).then(response =>{
          this.getProjetosFuncionario(projeto_funcionario.id_funcionario);
          toastr.success(projeto_funcionario.tx_projeto+' ativado com Sucesso');
        });
      },

      addProjeto: function(){

        var url = '/funcionario/projeto';

        this.add_projeto_funcionario.id_funcionario = this.projetos_funcionario[0].id_funcionario;
        this.add_projeto_funcionario.id_projeto = $('#add_id_projeto').val();

        axios.post(url,this.add_projeto_funcionario).then(response =>{
          //atualizo a lista de projetos do funcionario e tambem atualizo a lista de que ele nao faz parte
          this.getProjetosFuncionario(this.add_projeto_funcionario.id_funcionario);
          this.getProjetosNotFuncionario();
          toastr.success('Projeto Vinculado com Sucesso');
          $('#modal_add_projeto').modal('hide');
        });
      },

      deleteProjetoFuncionario: function(projeto_funcionario){
        
        var url = '/funcionario/projeto/'+projeto_funcionario.id_projeto+'/'+projeto_funcionario.id_grupo+'/'+projeto_funcionario.id_funcionario;

        axios.delete(url).then(response =>{
          if(response.data != ''){
            toastr.error(response.data);
          }else{
            //atualizo os projetos do funcionario
            this.getProjetosFuncionario(projeto_funcionario.id_funcionario);
            //e o projetos que ele nao faz parte
            this.getProjetosNotFuncionario();
            toastr.success('Projetos Excluídos');
          }
        });

      }      


    }

});
