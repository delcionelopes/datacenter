<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAutorizacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacao', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('perfil_id')->nullable();
            $table->integer('modulo_has_operacao_operacao_id')->nullable();
            $table->integer('modulo_has_operacao_modulo_id')->nullable();
            $table->integer('user_creater')->nullable();
            $table->integer('user_updater')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('modulo_has_operacao_modulo_id')->references('id')->on('modulo')->onDelete('cascade');
            $table->foreign('modulo_has_operacao_operacao_id')->references('id')->on('operacao')->onDelete('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autorizacao',function(Blueprint $table){
            $table->dropForeign([
                'modulo_has_operacao_modulo_id',
                'modulo_has_operacao_operacao_id',
                'perfil_id',
            ]);
        });
        Schema::dropIfExists('autorizacao');
    }
}
