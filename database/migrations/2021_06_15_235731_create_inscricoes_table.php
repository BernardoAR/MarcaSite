<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscricoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->unsignedBigInteger('usuarios_id');
            $table->unsignedBigInteger('cursos_id');
            $table->tinyInteger('status_id')->unsigned()->nullable();
            $table->foreign('usuarios_id')->references('id')->on('usuarios')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('cursos_id')->references('id')->on('cursos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('status')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
            $table->primary(array('usuarios_id', 'cursos_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscricoes');
    }
}
