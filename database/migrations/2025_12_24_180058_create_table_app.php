<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('orgao_id')->nullable();
            $table->integer('projeto_id')->nullable();
            $table->integer('base_id')->nullable();
            $table->string('nome_app',100);
            $table->string('dominio',100)->nullable();
            $table->text('senha')->nullable();
            $table->boolean('https')->default('true');
            $table->timestamp('validade')->nullable();
            $table->integer('val_indefinida')->nullable();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('base_id')->references('id')->on('bases');
            $table->foreign('orgao_id')->references('id')->on('orgao');
            $table->foreign('projeto_id')->references('id')->on('projetos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app',function(Blueprint $table){
            $table->dropForeign([
                'base_id',
                'orgao_id',
                'projeto_id',
            ]);
        });
        Schema::dropIfExists('app');
    }
}
