<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ofertas_Tecnologia;
use Faker\Generator as Faker;

$factory->define(Ofertas_Tecnologia::class, function (Faker $faker) {
    return [
        //oferta_id	tecnologia_id	created_at	updated_at
        'oferta_id' => \App\Oferta::all()->random()->id,
        'tecnologia_id' => \App\Tecnologia::all()->random()->id,

    ];
});
