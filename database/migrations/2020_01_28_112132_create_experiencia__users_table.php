<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienciaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiencia__users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('puesto', 50);
            $table->mediumText('descripcion');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');

            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser', 'fk_experiencia__users')
                ->on('users')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id', 'fk_experiencia__users_ciudads')
                ->on('ciudads')
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
        Schema::dropIfExists('experiencia__users');
    }
}
