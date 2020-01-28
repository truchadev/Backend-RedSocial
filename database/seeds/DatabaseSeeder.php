<?php

use Illuminate\Database\Seeder;


use App\User;
use App\Empresa;
use App\Oferta;
use App\Oferta_User;
use App\Experiencia_User;
use App\Estudio_User;




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
                "tipo" => $row->ColumnName
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
                "tipo" => $row->ColumnName
            ]);
        }

        //TIPO JORNADA
        //ruta del archivo
        $file4 = database_path('jsonSeeders/jornada.json');
        //Incluir archivo
        $json4 = file_get_contents($file4);
        //Recorrer el json
        foreach (json_decode($json4) as $row) {
            DB::table('j__laborals')->insert([
                "tipo" => $row->ColumnName
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
                "name" => $row->ColumnName
            ]);
        }

        //ESTADO
        $estados = ["revisando","aceptado", "rechazado"];
        foreach ($estados as $estado) {
            DB::table('estados')->insert([
                "tipo" => $estado
            ]);
        }

        Factory(User::class, 10)->create();
        Factory(Empresa::class, 10)->create();
        Factory(Oferta::class, 50)->create();
        Factory(Oferta_User::class, 50)->create();
        Factory(Experiencia_User::class, 75)->create();
        Factory(Estudio_User::class, 70)->create();
    }
}
