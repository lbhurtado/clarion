<?php

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

$factory->define(Clarion\Domain\Models\User::class, function (Faker $faker) {

    return [
        'mobile' => $faker->phoneNumber,
        'handle' => $faker->name,
    ];
});

$factory->define(Clarion\Domain\Models\Admin::class, function (Faker $faker) {

    return [
        'mobile' => $faker->phoneNumber,
        'handle' => $faker->name,
    ];
});