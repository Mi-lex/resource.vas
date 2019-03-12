<?php

use Illuminate\Database\Seeder;

use App\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'electricity'
            ],
            [
                'name' => 'water'
            ],
            [
                'name' => 'heat'
            ]
        ];

        foreach ($types as $type) {
            DB::table('types')->insert($type);
        }

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
