<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBasesHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bases_has_users', function (Blueprint $table) {
            $table->integer('base_id');
            $table->integer('user_id');

            $table->primary(['base_id','user_id']);
            $table->foreign('base_id')->references('id')->on('bases');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bases_has_users',function(Blueprint $table){
            $table->dropForeign([
                'base_id',
                'user_id',
            ]);
        });
        Schema::dropIfExists('bases_has_users');
    }
}
