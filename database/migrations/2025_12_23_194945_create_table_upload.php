<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload', function (Blueprint $table) {
            $table->id();
            $table->string('nome_arquivo',199)->nullable();
            $table->unsignedBigInteger('manual_id')->nullable();
            $table->binary('arquivo')->nullable();
            $table->timestamp('data_atual')->nullable()->useCurrent();
            $table->string('path_arquivo',255)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
           
            $table->foreign('manual_id')->references('id')->on('manuais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upload',function(Blueprint $table){
            $table->dropForeign([
                'manual_id',
            ]);
        });
        Schema::dropIfExists('upload');
    }
}
