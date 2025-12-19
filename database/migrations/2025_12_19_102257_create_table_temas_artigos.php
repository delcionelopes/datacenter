<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTemasArtigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas_artigos', function (Blueprint $table) {
            $table->integer('artigos_id');
            $table->integer('temas_id');

            $table->primary(['artigos_id','temas_id']);
            $table->foreign('artigos_id')->references('id')->on('artigos');
            $table->foreign('temas_id')->references('id')->on('temas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temas_artigos',function(Blueprint $table){
            $table->dropForeign([
                'artigos_id',
                'temas_id',
            ]);
        });
        Schema::dropIfExists('temas_artigos');
    }
}
