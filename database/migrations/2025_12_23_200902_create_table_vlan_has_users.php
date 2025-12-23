<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVlanHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlan_has_users', function (Blueprint $table) {
            $table->integer('vlan_id');
            $table->integer('user_id');

            $table->primary(['vlan_id','user_id']);
            $table->foreign('vlan_id')->references('id')->on('vlan')->onDelete('cascade');
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
        Schema::table('vlan_has_users',function(Blueprint $table){
            $table->dropForeign([
                'vlan_id',
                'user_id',
            ]);
        });
        Schema::dropIfExists('vlan_has_users');
    }
}
