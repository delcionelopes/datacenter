<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCadastroIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastro_ip', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('rede_id');
            $table->string('ip',15);            
            $table->string('status',20)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->unique('ip');
            $table->foreign('rede_id')->references('id')->on('rede');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadastro_ip',function(Blueprint $table){
            $table->dropForeign([
                'rede_id',
            ]);
        });
        Schema::dropIfExists('cadastro_ip');
    }
}
