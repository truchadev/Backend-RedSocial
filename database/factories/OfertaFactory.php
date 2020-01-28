<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Oferta;
use Faker\Generator as Faker;

$factory->define(Oferta::class, function (Faker $faker) {
    return [
        'puesto' => 'Full Stack Developer',
        'ciudad_id' => \App\Ciudades::all()->random()->id,
        'salario_min' => 10000,
        'salario_max' => 12000,
        'descripcion' => $faker-> paragraph($nbSentences = 4, $variableNbSentences = true),
        'tecnologia_id' => \App\Tecnologias::all()->random()->id,
        'empresa_id' => \App\Empresa::all()->random()->id,
        'estudios_min_id' => \App\Estudios::all()->random()->id,
        'tipo_contrato_id' => \App\Contratos::all()->random()->id ,
        'tipo_jornada_id' => \App\J_Laborals::all()->random()->id

    ];
});
