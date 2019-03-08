<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ElectricityConsumption::class, function (Faker $faker) {
    return [
        'device_id' => $faker->numberBetween(1, 6),
        'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days'),
        'sumDirectActive' => $faker->randomFloat(3, 1, 3),
        'sumInverseActive' => $faker->randomFloat(3, 1, 3),
        'sumDirectReactive' => $faker->randomFloat(3, 1, 3),
        'sumInverseReactive' => $faker->randomFloat(3, 1, 3),
        't1DirectActive' => $faker->randomFloat(3, 1, 3),
        't1InverseActive' => $faker->randomFloat(3, 1, 3),
        't1DirectReactive' => $faker->randomFloat(3, 1, 3),
        't1InverseRective' => $faker->randomFloat(3, 1, 3),
        't2DirectActive' => $faker->randomFloat(3, 1, 3),
        't2InverseActive' => $faker->randomFloat(3, 1, 3),
        't2DirectReactive' => $faker->randomFloat(3, 1, 3),
        't2InverseRective' => $faker->randomFloat(3, 1, 3),
        't3DirectActive' => $faker->randomFloat(3, 1, 3),
        't3InverseActive' => $faker->randomFloat(3, 1, 3),
        't3DirectReactive' => $faker->randomFloat(3, 1, 3),
        't3InverseRective' => $faker->randomFloat(3, 1, 3),
        't4DirectActive' => $faker->randomFloat(3, 1, 3),
        't4InverseActive' => $faker->randomFloat(3, 1, 3),
        't4DirectReactive' => $faker->randomFloat(3, 1, 3),
        't4InverseRective' => $faker->randomFloat(3, 1, 3)
    ];
});
