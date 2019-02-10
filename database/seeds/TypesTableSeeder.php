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
                'name' => 'electric'
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
    }
}
