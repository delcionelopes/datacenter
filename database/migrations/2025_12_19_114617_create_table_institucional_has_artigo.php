<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInstitucionalHasArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institucional_has_artigo', function (Blueprint $table) {
            $table->integer('institucional_id');
            $table->integer('artigos_id');

            $table->primary(['instituciona_id','artigos_id']);
            $table->foreign('institucional_id')->references('id')->on('institucional')->onDelete('cascade');
            $table->foreign('artigos_id')->references('id')->on('artigos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institucional_has_artigo',function(Blueprint $table){
            $table->dropForeign([
                'institucional_id',
                'artigos_id',
            ]);
        });
        Schema::dropIfExists('institucional_has_artigo');
    }
}
