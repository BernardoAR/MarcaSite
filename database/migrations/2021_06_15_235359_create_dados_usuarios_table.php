<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDadosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_usuarios', function (Blueprint $table) {
            $table->id();
            $table->char('CPF', 11);
            $table->string('empresa');
            $table->unsignedBigInteger('enderecos_id')->nullable();
            $table->tinyInteger('tipo_usuarios_id')->unsigned();
            $table->unsignedBigInteger('usuarios_id');
            $table->foreign('enderecos_id')->references('id')->on('enderecos')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('tipo_usuarios_id')->references('id')->on('tipo_usuarios')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_usuarios');
    }
}
