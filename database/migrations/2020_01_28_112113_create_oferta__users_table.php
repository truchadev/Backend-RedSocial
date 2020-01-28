<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta__users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('oferta_id');
            $table->foreign('oferta_id', 'fk_oferta__users_ofertas')
                ->on('ofertas')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk_oferta__users_users')
                ->on('users')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id', 'fk_oferta__users_estados')
                ->on('estados')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('tecnologia_id');
            $table->foreign('tecnologia_id', 'fk_oferta__users_tecnologias')
                ->on('tecnologias')
                ->references('id')
                ->onDelete('restrict');

//            $table->string('estado', 100);
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
        Schema::dropIfExists('oferta__users');
    }
}
