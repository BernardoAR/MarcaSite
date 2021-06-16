<?php

use App\Models\TipoContato;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_contatos', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);
            $table->string('titulo');
            $table->timestamps();
            $table->primary('id');
        });
        $this->posCriacao('Celular', 'Telefone');
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
            $model = new TipoContato();
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
        Schema::dropIfExists('tipo_contatos');
    }
}
