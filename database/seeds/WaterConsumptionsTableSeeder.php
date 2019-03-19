<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;

class WaterConsumptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        
        $records_amount = 2162;
        $active_water_meters = [7, 9, 17, 19, 21, 25, 23];

        foreach ($active_water_meters as $device_id) {
            $consumption_amount = $faker->randomFloat(1, 140000, 2);
            $start_date = Carbon::now()->subDays(90)->startOfDay();

            foreach (range(1, $records_amount) as $outer_index) {
                DB::table('water_consumptions')->insert([
                    'device_id' => $device_id,
                    'created_at' => $start_date,
                    'consumption_amount' => $consumption_amount += $faker->randomFloat(1, 100, 200)
                ]);

                $start_date->addHour();
            }
        }
    }
}
