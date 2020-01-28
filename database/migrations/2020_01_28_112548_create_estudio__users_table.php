<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudioUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudio__users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('centro', 50);
            $table->string('fecha_inicio');
            $table->string('fecha_fin');

            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser', 'fk_estudio__users_users')
                ->on('users')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id', 'fk_estudio__users_ciudads')
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
        Schema::dropIfExists('estudio__users');
    }
}
