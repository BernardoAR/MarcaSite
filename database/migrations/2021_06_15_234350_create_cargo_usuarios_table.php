<?php

use App\Models\CargoUsuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_usuarios', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);
            $table->string('titulo');
            $table->timestamps();
        });
        $this->posCriacao('Admin', 'Usuario');
    }
    /**
     * Método utilizado para a criação de titulos após a criação do schema
     *
     * @param string ...$tipos
     * @return void
     */
    private function posCriacao(string ...$tipos)
    {
        foreach ($tipos as $tipo) {
            $model = new CargoUsuario();
            $model->setAttribute('titulo', $tipo);
            $model->save();
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_usuarios');
    }
}
