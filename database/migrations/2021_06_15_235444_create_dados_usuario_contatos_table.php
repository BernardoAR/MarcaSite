<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDadosUsuarioContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_usuario_contatos', function (Blueprint $table) {
            $table->unsignedBigInteger('dados_usuarios_id');
            $table->unsignedBigInteger('contatos_id');
            $table->foreign('dados_usuarios_id')->references('id')->on('dados_usuarios')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('contatos_id')->references('id')->on('contatos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(array('dados_usuarios_id', 'contatos_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_usuario_contatos');
    }
}
