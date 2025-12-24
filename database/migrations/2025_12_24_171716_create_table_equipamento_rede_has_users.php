<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEquipamentoRedeHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamento_rede_has_users', function (Blueprint $table) {
            $table->integer('equipamento_rede_idequipamento_rede');
            $table->integer('users_id');
            $table->string('pass_user_equipamento')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary(['equipamento_rede_idequipamento_rede','users_id']);
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('equipamento_rede_idequipamento_rede')->references('idequipamento_rede')->on('equipamento_rede');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipamento_rede_has_users',function(Blueprint $table){
            $table->dropForeign([
                'users_id',
                'equipamento_rede_idequipamento_rede',
            ]);
        });
        Schema::dropIfExists('equipamento_rede_has_users');
    }
}
