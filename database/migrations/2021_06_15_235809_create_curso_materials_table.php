<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_materiais', function (Blueprint $table) {
            $table->unsignedBigInteger('cursos_id');
            $table->unsignedBigInteger('materiais_id');
            $table->foreign('cursos_id')->references('id')->on('cursos')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('materiais_id')->references('id')->on('materiais')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
            $table->primary(array('cursos_id', 'materiais_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso_materiais');
    }
}
