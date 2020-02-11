<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'prim_apellido' => $faker->lastName,
        'seg_apellido' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 12345678,
        'remember_token' => Str::random(10),
        'about' => $faker -> paragraph($nbSentences = 3, $variableNbSentences = true),
        'ciudad_id' => \App\Ciudad::all()->random()->id,
        'tecnologia_id'=>\App\Tecnologia::all()->random()->id,
        'estudios_id'=>\App\Estudio::all()->random()->id,
        'direccion'=> $faker->address,
        'telefono' => 665543261,
        'imagen' => "https://cdn.pixabay.com/photo/2015/09/02/13/24/girl-919048_1280.jpg"
    ];
});
