<?php

use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->tinyInteger('id', true, true);
            $table->string('titulo');
            $table->timestamps();
        });
        $this->posCriacao('Cancelado', 'Aguardando Pagamento ', 'Pago');
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
            $model = new Status();
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
        Schema::dropIfExists('status');
    }
}
