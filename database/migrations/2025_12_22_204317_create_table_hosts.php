<?php

use Brick\Math\BigInteger;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function (Blueprint $table) {
            $table->BigInteger('id');
            $table->integer('cluster_id')->nullable();
            $table->text('obs_host')->nullable();
            $table->string('ip',15)->nullable();
            $table->string('datacenter',50)->nullable();
            $table->string('cluster',50)->nullable();
            $table->text('senha');
            $table->timestamp('validade')->nullable();
            $table->integer('val_indefinida')->nullable();
            $table->integer('criador_id')->nullable();
            $table->integer('alterador_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id');
            $table->foreign('cluster_id')->references('id')->on('cluster')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hosts',function(Blueprint $table){
            $table->dropForeign([
                'cluster_id',
            ]);
        });
        Schema::dropIfExists('hosts');
    }
}
