<?php

use Faker\Generator as Faker;
use Clarion\Domain\Models as Models;

$factory->define(Models\Messenger::class, function (Faker $faker) {
    return [
        'driver' => $faker->title,
        'chat_id' => $faker->numberBetween(100000,999999),
    ];
});
