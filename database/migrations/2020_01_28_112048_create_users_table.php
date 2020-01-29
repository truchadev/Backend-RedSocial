<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('prim_apellido', 50)->nullable();
            $table->string('seg_apellido', 50)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->mediumText('about')->nullable();

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id', 'fk_users_ciudads')
                ->on('ciudads')
                ->references('id')
                ->onDelete('restrict')->nullable();

            $table->string('direccion', 100)->nullable();
            $table->binary('imagen')->nullable($value= true);
            $table->string('sexo', 50)->nullable();
            $table->string('especialidad', 50)->nullable();
            $table->integer('telefono' )->nullable()->unsigned();
            $table->rememberToken();
            //add fo activation and notifications
            $table->boolean('active')->default(false);
            $table->string('activation_token')->nullable();

            $table->timestamps();
            //add fo activation and notifications
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
