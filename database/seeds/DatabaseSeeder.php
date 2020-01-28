<?php

use Illuminate\Database\Seeder;


use App\Users;
use App\Empresas;
use App\Ofertas;
use App\Oferta_Users;
use App\Experiencia_Users;
use App\Estudio_Users;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Factory(Users::class, 10)->create();
        Factory(Empresas::class, 10)->create();
        Factory(Ofertas::class, 50)->create();
        Factory(Oferta_Users::class, 50)->create();
        Factory(Experiencia_Users::class, 10)->create();
        Factory(Estudio_Users::class, 10)->create();
    }
}
