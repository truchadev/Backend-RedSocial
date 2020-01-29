<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaTecnologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta__tecnologias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('oferta_id');
            $table->foreign('oferta_id', 'fk_oferta__tecnologias_ofertas')
                ->on('ofertas')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('tecnologia_id');
            $table->foreign('tecnologia_id', 'fk_oferta__tecnologias_tecnologias')
                ->on('tecnologias')
                ->references('id')
                ->onDelete('restrict');

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
        Schema::dropIfExists('oferta__tecnologias');
    }
}
