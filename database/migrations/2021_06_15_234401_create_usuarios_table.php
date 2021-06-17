<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verificado')->nullable();
            $table->string('senha');
            $table->string('api_token', 80);
            $table->tinyInteger('cargo_usuarios_id')->unsigned()->nullable()->default(2);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('cargo_usuarios_id')->references('id')->on('cargo_usuarios')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
