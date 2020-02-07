<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Experiencia_User;
use Faker\Generator as Faker;

$factory->define(Experiencia_User::class, function (Faker $faker) {
    return [
        'puesto' => \App\Estado::all()->random()->id,
        'descripcion' => $faker-> paragraph($nbSentences = 4, $variableNbSentences = true),
        'fecha_inicio' => $faker ->date($format = 'Y-m-d', $max = '-30 years'),
        'fecha_fin' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_id' => \App\User::all()->random()->id,
//        'ciudad_id' => \App\Ciudad::all()->random()->id,
    ];
});
