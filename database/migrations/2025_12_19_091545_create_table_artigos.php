<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArtigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos', function (Blueprint $table) {
            $table->integer('id');
            $table->string('titulo',100)->nullable();
            $table->string('descricao',190)->nullable();
            $table->text('conteudo');
            $table->string('slug',190)->nullable();
            $table->string('imagem',190)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artigos',function(Blueprint $table){
            $table->dropForeign([
                'user_id',
            ]);
        });
        Schema::dropIfExists('artigos');
    }
}
