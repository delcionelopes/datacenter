<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableManuais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuais', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('setor_id')->nullable();
            $table->timestamp('data_criacao')->nullable();
            $table->timestamp('data_atualizacao')->nullable();
            $table->string('descricao',100)->nullable();
            $table->text('objetivo')->nullable();
            $table->text('manual')->nullable();
            $table->integer('area_conhecimento_id');
            $table->string('usuario',20)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('area_conhecimento_id')->references('id')->on('area_conhecimento')->onDelete('cascade');
            $table->foreign('setor_id')->references('idsetor')->on('setor')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuais',function(Blueprint $table){
            $table->dropForeign([
                'area_conhecimento_id',
                'setor_id',
            ]);
        });
        Schema::dropIfExists('manuais');
    }
}
