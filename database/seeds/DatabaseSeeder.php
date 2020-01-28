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
        //CIUDADES
        //ruta del archivo
        $file = database_path('jsonSeeders/cities.json');
        //Incluir archivo
        $json = file_get_contents($file);
        //Recorrer el json
        foreach (json_decode($json) as $row) {
            DB::table('ciudads')->insert([
                "name" => $row->name
            ]);
        }

        //TIPO CONTRATOS
        //ruta del archivo
        $file2 = database_path('jsonSeeders/contrato.json');
        //Incluir archivo
        $json2 = file_get_contents($file2);
        //Recorrer el json
        foreach (json_decode($json2) as $row) {
            DB::table('contratos')->insert([
                "name" => $row->name
            ]);
        }

        //ESTUDIOS
        //ruta del archivo
        $file3 = database_path('jsonSeeders/estudios.json');
        //Incluir archivo
        $json3 = file_get_contents($file3);
        //Recorrer el json
        foreach (json_decode($json3) as $row) {
            DB::table('estudios')->insert([
                "name" => $row->name
            ]);
        }

        //TIPO JORNADA
        //ruta del archivo
        $file4 = database_path('jsonSeeders/jornada.json');
        //Incluir archivo
        $json4 = file_get_contents($file4);
        //Recorrer el json
        foreach (json_decode($json4) as $row) {
            DB::table('j_laborals')->insert([
                "name" => $row->name
            ]);
        }

        //TECNOLOGIAS
        //ruta del archivo
        $file5 = database_path('jsonSeeders/tecnologias.json');
        //Incluir archivo
        $json5 = file_get_contents($file5);
        //Recorrer el json
        foreach (json_decode($json5) as $row) {
            DB::table('tecnologias')->insert([
                "name" => $row->name
            ]);
        }

        Factory(Users::class, 10)->create();
        Factory(Empresas::class, 10)->create();
        Factory(Ofertas::class, 50)->create();
        Factory(Oferta_Users::class, 50)->create();
        Factory(Experiencia_Users::class, 10)->create();
        Factory(Estudio_Users::class, 10)->create();
    }
}
