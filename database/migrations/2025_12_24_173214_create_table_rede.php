<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRede extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rede', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('vlan_id')->nullable();
            $table->string('nome_rede',100)->nullable();
            $table->string('mascara',15)->nullable();
            $table->string('tipo_rede',20)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('vlan_id')->references('id')->on('vlan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rede',function(Blueprint $table){
            $table->dropForeign([
                'vlan_id',
            ]);
        });
        Schema::dropIfExists('rede');
    }
}
