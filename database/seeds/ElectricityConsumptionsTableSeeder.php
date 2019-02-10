<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;

class ElectricityConsumptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $start_date = Carbon::createFromTimeStamp($faker
            ->dateTimeBetween($startDate = '-30 days', $endDate = '-29 days')
            ->getTimestamp());
        $records_amount = 50;
        $devices_amount = 6;

        foreach (range(1, $devices_amount) as $device_id) {
            
            $sumDirectActive = $faker->randomFloat(3, 1, 3);
            $sumInverseActive = $faker->randomFloat(3, 1, 4);
            $sumDirectReactive = $faker->randomFloat(3, 2, 5);
            $sumInverseReactive = $faker->randomFloat(3, 1, 3);
            $t1DirectActive = $faker->randomFloat(3, 1, 3);
            $t1InverseActive = $faker->randomFloat(3, 1, 3);
            $t1DirectReactive = $faker->randomFloat(3, 1, 3);
            $t1InverseRective = $faker->randomFloat(3, 3, 6);
            $t2DirectActive = $faker->randomFloat(3, 1, 3);
            $t2InverseActive = $faker->randomFloat(3, 1, 3);
            $t2DirectReactive = $faker->randomFloat(3, 1, 3);
            $t2InverseRective = $faker->randomFloat(3, 1, 3);
            $t3DirectActive = $faker->randomFloat(3, 1, 3);
            $t3InverseActive = $faker->randomFloat(3, 1, 3);
            $t3DirectReactive = $faker->randomFloat(3, 2, 4);
            $t3InverseRective = $faker->randomFloat(3, 1, 3);
            $t4DirectActive = $faker->randomFloat(3, 1, 3);
            $t4InverseActive = $faker->randomFloat(3, 1, 3);
            $t4DirectReactive = $faker->randomFloat(3, 1, 3);
            $t4InverseRective = $faker->randomFloat(3, 1, 3);

            foreach (range(1, $records_amount) as $outer_index) {

                DB::table('electricity_consumptions')->insert([
                    'device_id' => $device_id,
                    'created_at' => $start_date,
                    'sumDirectActive' => $sumDirectActive += $faker->randomFloat(3, 1, 2),
                    'sumInverseActive' => $sumInverseActive += $faker->randomFloat(3, 1, 2),
                    'sumDirectReactive' => $sumDirectReactive += $faker->randomFloat(3, 1, 2),
                    'sumInverseReactive' => $sumInverseReactive += $faker->randomFloat(3, 1, 2),
                    't1DirectActive' => $t1DirectActive += $faker->randomFloat(3, 1, 2),
                    't1InverseActive' => $t1InverseActive += $faker->randomFloat(3, 1, 2),
                    't1DirectReactive' => $t1DirectReactive += $faker->randomFloat(3, 1, 2),
                    't1InverseRective' => $t1InverseRective += $faker->randomFloat(3, 1, 2),
                    't2DirectActive' => $t2DirectActive += $faker->randomFloat(3, 1, 2),
                    't2InverseActive' => $t2InverseActive += $faker->randomFloat(3, 1, 2),
                    't2DirectReactive' => $t2DirectReactive += $faker->randomFloat(3, 1, 2),
                    't2InverseRective' => $t2InverseRective += $faker->randomFloat(3, 1, 2),
                    't3DirectActive' => $t3DirectActive += $faker->randomFloat(3, 1, 2),
                    't3InverseActive' => $t3InverseActive += $faker->randomFloat(3, 1, 2),
                    't3DirectReactive' => $t3DirectReactive += $faker->randomFloat(3, 1, 2),
                    't3InverseRective' => $t3InverseRective += $faker->randomFloat(3, 1, 2),
                    't4DirectActive' => $t4DirectActive += $faker->randomFloat(3, 1, 2),
                    't4InverseActive' => $t4InverseActive += $faker->randomFloat(3, 1, 2),
                    't4DirectReactive' => $t4DirectReactive += $faker->randomFloat(3, 1, 2),
                    't4InverseRective' => $t4InverseRective += $faker->randomFloat(3, 1, 2)
                ]);
            }
        }
    }
}
