<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Oferta_User;
use Faker\Generator as Faker;

$factory->define(Oferta_User::class, function (Faker $faker) {
    return [
        'oferta_id' => \App\Oferta::all()->random()->id,
        'user_id' => \App\User::all()->random()->id,
        'estado_id' => \App\Estado::all()->random()->id,
        'tecnologia_id' => \App\Estado::all()->random()->id,
    ];
});
