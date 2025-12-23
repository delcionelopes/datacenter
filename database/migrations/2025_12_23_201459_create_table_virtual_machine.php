<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVirtualMachine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_machine', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('nome_vm',100)->nullable();
            $table->float('cpu')->nullable();
            $table->float('memoria')->nullable();
            $table->float('disco')->nullable();
            $table->string('ip',50)->nullable();
            $table->string('resource_pool',150)->nullable();
            $table->string('cluster',50)->nullable();
            $table->string('sistema_operacional',80)->nullable();
            $table->string('gatway',20)->nullable();
            $table->integer('ambiente_id')->nullable();
            $table->integer('orgao_id')->nullable();
            $table->integer('cluster_id')->nullable();
            $table->integer('projeto_id')->nullable();
            $table->timestamp('validade')->nullable();
            $table->integer('val_indefinida')->nullable();
            $table->text('senha')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();

            $table->primary('id');
            $table->foreign('ambiente_id')->references('id')->on('ambientes')->onDelete('cascade');
            $table->foreign('orgao_id')->references('id')->on('orgao')->onDelete('cascade');
            $table->foreign('cluster_id')->references('id')->on('cluster')->onDelete('cascade');
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtual_machine',function(Blueprint $table){
            $table->dropForeign([
                'ambiente_id',
                'orgao_id',
                'cluster_id',
                'projeto_id',
            ]);
        });
        Schema::dropIfExists('virtual_machine');
    }
}
