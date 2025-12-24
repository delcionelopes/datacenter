<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableModuloHasOperacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_has_operacao', function (Blueprint $table) {
            $table->smallInteger('id');
            $table->integer('modulo_id');
            $table->integer('operacao_id');

            $table->primary(['id','modulo_id','operacao_id']);
            $table->foreign('modulo_id')->references('id')->on('modulo')->onDelete('cascade');
            $table->foreign('operacao_id')->references('id')->on('operacao')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modulo_has_operacao',function(Blueprint $table){
            $table->dropForeign([
                'modulo_id',
                'operacao_id',
            ]);
        });
        Schema::dropIfExists('modulo_has_operacao');
    }
}
