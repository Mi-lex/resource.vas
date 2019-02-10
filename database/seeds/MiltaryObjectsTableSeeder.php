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
    }
}
