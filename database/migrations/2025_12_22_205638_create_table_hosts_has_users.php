<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHostsHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts_has_users', function (Blueprint $table) {
            $table->integer('host_id');            
            $table->integer('user_id');

            $table->primary(['host_id','user_id']);
            $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hosts_has_users',function(Blueprint $table){
            $table->dropForeign([
                'host_id',
                'user_id',
            ]);
        });
        Schema::dropIfExists('hosts_has_users');
    }
}
