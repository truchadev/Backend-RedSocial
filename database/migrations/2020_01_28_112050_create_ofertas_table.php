<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('puesto', 100);

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id', 'fk_ofertas_ciudads')
                ->on('ciudads')
                ->references('id')
                ->onDelete('restrict');

            $table->string('salario_min', 25);
            $table->string('salario_max', 25);
            $table->mediumText('descripcion');
            $table->integer('experiencia_min')->unsigned();

            $table->unsignedBigInteger('tecnologia_id');
            $table->foreign('tecnologia_id', 'fk_ofertas_tecnologias')
                ->on('tecnologias')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id', 'fk_ofertas_empresas')
                ->on('empresas')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('estudios_min_id');
            $table->foreign('estudios_min_id', 'fk_ofertas_estudios')
                ->on('estudios')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('tipo_contrato_id');
            $table->foreign('estudios_min_id', 'fk_ofertas_contratos')
                ->on('contratos')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('tipo_jornada_id');
            $table->foreign('tipo_jornada_id', 'fk_ofertas_j__laborals')
                ->on('j__laborals')
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
        Schema::dropIfExists('ofertas');
    }
}
