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

        foreach (range(1, $records_amount) as $outer_index) {
            foreach (range(1, $devices_amount) as $device_id) {
                factory(App\ElectricityConsumption::class)->create([
                    'device_id' => $device_id,
                    'created_at' => $start_date
                ]);
            }

            $start_date->addHour();
        }
    }
}
