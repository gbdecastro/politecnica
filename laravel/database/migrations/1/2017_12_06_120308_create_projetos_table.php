<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->integer('id_projeto')->unsigned();
            $table->integer('id_grupo')->unsigned();
            $table->string('tx_projeto')->nullable();
            $table->timestamps();
        });

        Schema::table('projetos', function (Blueprint $table) {
            $table->primary(['id_projeto','id_grupo']);
            $table->foreign('id_grupo')->references('id_grupo')->on('grupos');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projetos');
    }
}
