<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEquipamentoRede extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamento_rede', function (Blueprint $table) {
            $table->integer('idequipamento_rede');
            $table->integer('setor_idsetor')->nullable();
            $table->string('nome',50)->nullable();
            $table->string('descricao',100)->nullable();
            $table->string('pass_admin',200)->nullable();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('idequipamento_rede');
            $table->foreign('setor_idsetor')->references('idsetor')->on('setor');
            $table->foreign('alterador_id')->references('id')->on('users');
            $table->foreign('criador_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipamento_rede',function(Blueprint $table){
            $table->dropForeign([
                'setor_idsetor',
                'alterador_id',
                'criador_id',
            ]);
        });
        Schema::dropIfExists('equipamento_rede');
    }
}
