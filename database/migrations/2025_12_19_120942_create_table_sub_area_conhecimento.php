<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubAreaConhecimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_area_conhecimento', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('descricao',80)->nullable();
            $table->integer('area_conhecimento_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('area_conhecimento_id')->references('id')->on('area_conhecimento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_area_conhecimento',function(Blueprint $table){
            $table->dropForeign([
                'area_conhecimento_id',
            ]);
        });
        Schema::dropIfExists('sub_area_conhecimento');
    }
}
