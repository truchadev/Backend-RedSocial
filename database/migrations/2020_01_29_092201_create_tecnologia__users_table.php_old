<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTecnologiaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecnologia__users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk_tecnologia__users_users')
                ->on('users')
                ->references('id')
                ->onDelete('restrict');

            $table->unsignedBigInteger('tecnologia_id');
            $table->foreign('tecnologia_id', 'fk_tecnologia__users_tecnologias')
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
        Schema::dropIfExists('tecnologia__users');
    }
}
