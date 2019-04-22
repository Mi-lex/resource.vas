<?php

use Illuminate\Database\Seeder;

class MiltaryDistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            'Западный военный округ',
            'Южный военный округ',
            'Северный флот',
            'Центральный военный округ',
            'Восточный военный округ',
        ];

        foreach ($districts as $district_name) {
            DB::table('miltary_districts')->insert([
                'name' => $district_name
            ]);
        }
    }
}
