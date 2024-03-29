<?php

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = [
            [
                'name' => 'Главный копрус',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1936',
                'updated_at' => '2014',
                'area' => 35300,
                'floors' => 5,
                'max_emit_power' => 1273,
                'max_reserve_power' => 700
            ],
            [
                'name' => 'Учебно-лабораторный корпус',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1988',
                'updated_at' => '2014',
                'area' => 51404,
                'floors' => 7,
                'max_emit_power' => 1461,
                'max_reserve_power' => 108
            ],
            [
                'name' => 'Учебный корпус',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1975',
                'updated_at' => '2014',
                'area' => 3733,
                'floors' => 7,
                'max_emit_power' => 103,
            ],
            [
                'name' => 'Общежите специального факультета',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1970',
                'updated_at' => '2014',
                'area' => 10599,
                'floors' => 7,
            ],
            [
                'name' => 'Общежите 3 факультета',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1969',
                'updated_at' => '2014',
                'area' => 10461,
                'floors' => 7,
            ],
            [
                'name' => 'Общежите 2 факультета',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 16039,
                'floors' => 12,
            ],
            [
                'name' => 'Общежите 1 факультета',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 33920,
                'floors' => 12,
            ],
            [
                'name' => 'Общежите военнослужащих женского пола',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1980',
                'updated_at' => '2014',
                'area' => 6434,
                'floors' => 5,
            ],
            [
                'name' => 'Бассейн',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2013',
                'updated_at' => '2014',
                'area' => 1729,
                'floors' => 2,
                'max_emit_power' => 182,
                'max_reserve_power' => 34
            ],
            [
                'name' => 'Столовая',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 14544,
                'floors' => 2,
            ],
            [
                'name' => 'Поликлиника',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 1038,
                'floors' => 2,
            ],
            [
                'name' => 'Продовольственный склад',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 834,
                'floors' => 2,
            ],
            [
                'name' => 'Спортивный зал',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '1972',
                'updated_at' => '2014',
                'area' => 3532,
                'floors' => 2,
                'max_emit_power' => 61,
            ],
            [
                'name' => 'Контроьлно-пропускной пункт №2',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 204,
                'floors' => 1,
            ],
            [
                'name' => 'Школа IT-технологий',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2015',
                'area' => 6347,
                'floors' => 4,
            ],
            [
                'name' => 'Универсальный спортивный комплекс',
                'object_id' => 1,
                'sector_id' => 1,
                'created_at' => '2014',
                'area' => 5199,
                'floors' => 1,
            ],
            [
                'name' => 'Трансформаторная подстанция',
                'object_id' => 1,
                'sector_id' => 1,
                'floors' => 1,
            ],
        ];

        foreach ($buildings as $building) {
            DB::table('buildings')->insert($building);
        }
    }
}
