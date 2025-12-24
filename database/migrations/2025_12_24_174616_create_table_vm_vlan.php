<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVmVlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_vlan', function (Blueprint $table) {
            $table->integer('virtual_machine_id');
            $table->integer('vlan_id');

            $table->primary(['virtual_machine_id','vlan_id']);
            $table->foreign('virtual_machine_id')->references('id')->on('virtual_machine');
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
        Schema::table('vm_vlan',function(Blueprint $table){
            $table->dropForeign([
                'virtual_machine_id',
                'vlan_id',
            ]);
        });
        Schema::dropIfExists('vm_vlan');
    }
}
