<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Oferta;
use Faker\Generator as Faker;

$factory->define(Oferta::class, function (Faker $faker) {
    return [
        'puesto' => 'Full Stack Developer',
        'ciudad_id' => \App\Ciudad::all()->random()->id,
        'salario_min' => 10000,
        'salario_max' => 12000,
        'descripcion' => $faker-> paragraph($nbSentences = 4, $variableNbSentences = true),
        'experiencia_min' => random_int(0, 40),
//        'ofertas_tecnologia_id' => \App\Ofertas_Tecnologia::all()->random()->id,
        'empresa_id' => \App\Empresa::all()->random()->id,
        'estudios_min_id' => \App\Estudio::all()->random()->id,
        'tipo_contrato_id' => \App\Contrato::all()->random()->id ,
        'tipo_jornada_id' => \App\J_Laboral::all()->random()->id
    ];
});
