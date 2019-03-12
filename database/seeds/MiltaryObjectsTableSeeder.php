<?php

use Illuminate\Database\Seeder;

class MiltaryObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $miltary_objects = [
            [
                'name' => 'Военная академия связи имени С. М. Будённого',
                'district_id' => 1,
                'address' => 'Тихорецкий пр., 3, Санкт-Петербург'
            ],
            [
                'name' => 'Военная академия материально-технического обеспечения 
                    имени генерала армии А. В. Хрулёва',
                'district_id' => 1,
                'address' => 'наб. Макарова, 8, Санкт-Петербург'
            ],
            [
                'name' => 'Военно-медицинская академия имени С. М. Кирова',
                'district_id' => 1,
                'address' => 'ул. Академика Лебедева, лит. Ж, Санкт-Петербург'
            ],
        ];

        foreach ($miltary_objects as $miltary_object) {
            DB::table('miltary_objects')->insert($miltary_object);
        }

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
