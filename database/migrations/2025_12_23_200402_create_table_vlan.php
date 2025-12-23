<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlan', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('nome_vlan',100)->nullable();
            $table->text('senha')->nullable();
            $table->timestamp('validade')->nullable();
            $table->integer('val_indefinida')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vlan');
    }
}
