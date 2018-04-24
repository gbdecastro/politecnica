<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorasProjetosFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('horas_projetos_funcionarios', function (Blueprint $table) {
            $table->integer('id_funcionario')->unsigned();
            $table->integer('id_projeto')->unsigned();
            $table->integer('id_grupo')->unsigned();
            $table->date('dt_trabalho');
            $table->integer('nb_horas_trabalho');
            $table->float('nb_despesa');
            $table->timestamps();
        });

        Schema::table('horas_projetos_funcionarios', function (Blueprint $table) {

            $table->foreign('id_funcionario')->references('id_usuario')->on('users');
            
            $table->foreign(['id_projeto','id_grupo'])
                  ->references(['id_projeto','id_grupo'])
                  ->on('projetos');

            $table->primary(['id_projeto','id_funcionario','dt_trabalho', 'id_grupo'],'primary_h_P_f');

        });         
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
    }    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horas_projetos_funcionarios');
    }
}
