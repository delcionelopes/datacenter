<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->string('email',191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',191);
            $table->rememberToken();
            $table->boolean('moderador')->nullable();
            $table->string('avatar',150)->nullable();
            $table->string('cpf',11)->unique();
            $table->string('matricula',10)->nullable();
            $table->integer('orgao_id')->nullable();
            $table->boolean('inativo')->nullable();
            $table->string('link_instagram',190)->nullable();
            $table->string('link_facebook',190)->nullable();
            $table->string('link_site',190)->nullable();
            $table->integer('setor_id')->nullable();
            $table->boolean('admin')->nullable();
            $table->integer('funcao_id')->nullable();
            $table->integer('perfil_id')->nullable();
            $table->boolean('sistema')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            
            $table->foreign('orgao_id')->references('id')->on('orgao')->onDelete('cascade');
            $table->foreign('setor_id')->references('idsetor')->on('setor')->onDelete('cascade');
            $table->foreign('funcao_id')->references('id')->on('funcao')->onDelete('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropForeign([
                'orgao_id',
                'setor_id',
                'funcao_id',
                'perfil_id',
            ]);
        });
        Schema::dropIfExists('users');
    }
}
