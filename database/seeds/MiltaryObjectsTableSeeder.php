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
                'address' => 'Тихорецкий пр., 3, Санкт-Петербург'
            ],
            [
                'name' => 'Военная академия материально-технического обеспечения 
                    имени генерала армии А. В. Хрулёва',
                'address' => 'наб. Макарова, 8, Санкт-Петербург'
            ],
            [
                'name' => 'Военно-медицинская академия имени С. М. Кирова',
                'address' => 'ул. Академика Лебедева, лит. Ж, Санкт-Петербург'
            ],
        ];

        foreach ($miltary_objects as $miltary_object) {
            DB::table('miltary_objects')->insert([
                'name' => $miltary_object['name'],
                'address' => $miltary_object['address'],
            ]);
        }
    }
}
