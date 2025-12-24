<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVirtualMachineHasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_machine_has_users', function (Blueprint $table) {
            $table->integer('virtual_machine_id');
            $table->integer('user_id');

            $table->primary(['virtual_machine_id','user_id']);
            $table->foreign('virtual_machine_id')->references('id')->on('virtual_machine');
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
        Schema::table('virtual_machine_has_users',function(Blueprint $table){
            $table->dropForeign([
                'virtual_machine_id',
                'user_id',
            ]);
        });
        Schema::dropIfExists('virtual_machine_has_users');
    }
}
