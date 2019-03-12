<?php

use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drivers = [
            [
                'name' => 'mercury_230'
            ],
            [
                'name' => 'impis_12'
            ],
            [
                'name' => 'logika_941'
            ],
            [
                'name' => 'oven_si9'
            ],
            [
                'name' => 'pulsar_2m'
            ],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
