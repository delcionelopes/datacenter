<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bases', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('projetos_id')->nullable();
            $table->integer('virtual_machine_id')->nullable();
            $table->string('nome_base',100);
            $table->string('ip',15)->nullable();
            $table->string('dono',50)->nullable();
            $table->string('encoding',30)->nullable();
            $table->text('senha')->nullable();
            $table->timestamp('validade')->nullable();
            $table->integer('val_indefinida')->nullable();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->unique('nome_base');
            $table->foreign('projetos_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->foreign('virtual_machine_id')->references('id')->on('virtual_machine')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bases',function(Blueprint $table){
            $table->dropForeign([
                'projetos_id',
                'virtual_machine_id',
            ]);
        });
        Schema::dropIfExists('bases');
    }
}
