<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAppHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_has_users', function (Blueprint $table) {
            $table->integer('app_id');
            $table->integer('user_id');

            $table->primary(['app_id','user_id']);
            $table->foreign('app_id')->references('id')->on('app');
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
        Schema::table('app_has_users',function(Blueprint $table){
            $table->dropForeign([
                'app_id',
                'user_id',
            ]);
        });
        Schema::dropIfExists('app_has_users');
    }
}
