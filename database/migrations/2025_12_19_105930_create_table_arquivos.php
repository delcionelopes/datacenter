<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('user_id')->nullable();
            $table->integer('artigos_id')->nullable();
            $table->string('nome',100)->nullable();
            $table->string('rotulo',100)->nullable();
            $table->string('path',190)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('arquivos',function(Blueprint $table){
            $table->dropForeign([
                'user_id',
                'artigos_id',
            ]);
        });
        Schema::dropIfExists('arquivos');
    }
}
