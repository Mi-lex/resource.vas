<?php

use Illuminate\Database\Seeder;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            [
                'name' => 'Военный городок №123',
                'object_id' => 1,
                'address' => 'Санкт-Петербург, Тихорецкий пр., д. 3'
            ],
            [
                'name' => 'Военный городок №5',
                'object_id' => 1,
                'address' => 'Санкт-Петербург, Песочное шоссе, 46'
            ],
            [
                'name' => 'Военный городок №6',
                'object_id' => 1,
                'address' => 'Ленинградская область, Всеволожский район, 25 км Выборгского шоссе'
            ],
            [
                'name' => 'Военный городок №84',
                'object_id' => 1,
                'address' => 'Санкт-Петербург, Суворовский пр. 32Б'
            ],
            [
                'name' => 'Учебный центр (инженерно-технический)',
                'object_id' => 1,
                'address' => 'Ленинградская область, Гатчинский район, деревня Вайялово, городок Ижора, 2'
            ],
        ];

        foreach ($sectors as $sector) {
            DB::table('sectors')->insert($sector);
        }
    }
}
