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
                // 2 - 8
            ],
            [
                'name' => 'impis_12'
                // 19, 20, 21 - пока не работают
            ],
            [
                'name' => 'logika_941'
            ],
            [
                'name' => 'oven_si9'
                // 9
            ],
            [
                'name' => 'pulsar_2m'
                // 23, 25
            ],
            [
                'name' => 'logika_943'
            ],
            [
                'name' => 'oven_si30'
            ],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
