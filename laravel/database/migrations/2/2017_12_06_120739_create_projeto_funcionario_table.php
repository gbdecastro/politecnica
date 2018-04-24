<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetoFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos_funcionarios', function (Blueprint $table) {
            $table->integer('id_funcionario')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->integer('id_grupo')->unsigned();
            $table->timestamps();
        });

        Schema::table('projetos_funcionarios', function (Blueprint $table) {
            
            $table->primary(['id_funcionario','id_projeto','id_grupo'], 'pk_projetos_funcionarios');

            $table->foreign('id_funcionario')
                  ->references('id_usuario')
                  ->on('users');
                  
            $table->foreign(['id_projeto','id_grupo'])
                  ->references(['id_projeto','id_grupo'])
                  ->on('projetos');
        });         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
