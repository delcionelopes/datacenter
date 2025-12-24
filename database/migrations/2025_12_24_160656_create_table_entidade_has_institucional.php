<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEntidadeHasInstitucional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidade_has_institucional', function (Blueprint $table) {
            $table->integer('entidade_id');
            $table->integer('institucional_id');

            $table->primary(['entidade_id','institucional_id']);
            $table->foreign('entidade_id')->references('id')->on('entidade');
            $table->foreign('institucional_id')->references('id')->on('institucional');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entidade_has_institucional',function(Blueprint $table){
            $table->dropForeign([
                'entidade_id',
                'institucional_id',
            ]);
        });
        Schema::dropIfExists('entidade_has_institucional');
    }
}
