<?php

use Faker\Generator as Faker;
use Clarion\Domain\Models as Models;
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

$children = [
    Models\User::class,
    Models\Admin::class,
    Models\Operator::class,
    Models\Staff::class,
    Models\Subscriber::class,
    Models\Worker::class,
];

foreach ($children as $child) {
    $factory->define($child, function (Faker $faker) {

        return [
            'mobile' => $faker->phoneNumber,
            'handle' => $faker->name,
        ];
    });
}