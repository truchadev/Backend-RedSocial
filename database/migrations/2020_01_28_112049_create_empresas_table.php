<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('cif', 50)->nullable()->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->mediumText('about')->nullable();

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id', 'fk_empresas_ciudads')
                ->on('ciudads')
                ->references('id')
                ->onDelete('restrict')->nullable();

            $table->string('direccion', 50)->nullable();
            $table->binary('imagen_logo')->nullable();
            $table->string('name_responsable', 50);
            $table->integer('telefono')->nullable()->unsigned();
            $table->string('web', 50)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('empresas');
    }
}
