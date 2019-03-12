<?php

use Illuminate\Database\Seeder;

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
    }
}
