<?php

use App\Models\TipoUsuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_usuarios', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);
            $table->string('titulo');
            $table->timestamps();
            $table->primary('id');
        });
        $this->posCriacao('Estudante', 'Profissional', 'Associado');
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
            $model = new TipoUsuario();
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
        Schema::dropIfExists('tipo_usuarios');
    }
}
