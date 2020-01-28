<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Estudio_User;
use Faker\Generator as Faker;

$factory->define(Estudio_User::class, function (Faker $faker) {
    return [
        'estudio_id' => \App\Estudio::all()->random()->id,
        'centro' => $faker->company,
        'fecha_inicio' => $faker ->date($format = 'Y-m-d', $max = '-30 years'),
        'fecha_fin' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_id' => \App\User::all()->random()->id,
        'ciudad_id' => \App\Ciudad::all()->random()->id
    ];
});
