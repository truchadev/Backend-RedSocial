<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'name' => $faker -> company,
        'cif' => $faker ->unique() -> isbn13,
        'email' => $faker ->unique()->safeEmail,
        'password' => $faker ->unique()->safeEmail,
        'about' => $faker -> paragraph($nbSentences = 5, $variableNbSentences = true),
        'ciudad_id' => \App\Ciudads::all()->random()->id,
        'direccion' => $faker -> address,
        'name_responsable' => $faker -> name,
        'telefono' => $faker -> phoneNumber,
        'web'=> $faker -> url
    ];
});
