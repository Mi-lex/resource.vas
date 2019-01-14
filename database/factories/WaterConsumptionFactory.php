<?php

use Faker\Generator as Faker;

$factory->define(App\WaterConsumption::class, function (Faker $faker) {
    return [
        'device_id' => $faker->numberBetween(1, 6),
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days'),
        'consumption_amount' => $faker->randomFloat(1, 140000, 2)
    ];
});
