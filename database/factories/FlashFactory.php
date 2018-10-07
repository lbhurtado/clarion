<?php

use Faker\Generator as Faker;
use Clarion\Domain\Models\{Flash, User};

$factory->define(Flash::class, function (Faker $faker) {
    return [
        'code' => $faker->word,
        'type' => $faker->randomElement(['admin', 'staff', 'operator']),
        'user_id' => factory(User::class)->create()->id,
    ];
});
