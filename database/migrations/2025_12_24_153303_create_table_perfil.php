<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePerfil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->id();
            $table->string('nome',20)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        Schema::table('users',function(Blueprint $table){
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->unsignedBigInteger('orgao_id')->nullable();
            $table->unsignedBigInteger('setor_id')->nullable();
            $table->unsignedBigInteger('funcao_id')->nullable();

            $table->foreign('perfil_id')->references('id')->on('perfil');
            $table->foreign('orgao')->references('id')->on('orgao');
            $table->foreign('setor_id')->references('idsetor')->on('setor');
            $table->foreign('funcao_id')->references('id')->on('funcao');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil');
    }
}
