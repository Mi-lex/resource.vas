<?php

use Illuminate\Database\Seeder;

class ConvertersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $converters = [
            [
                "name" => "Bolid C2000-Ethernet",
                "protocol" => "udp"
            ],
            [
                "name" => "Moxa NPort 5150",
                "protocol" => "tcp",
            ],
            [
                "name" => "USR-TCP232-302",
                "protocol" => "tcp"
            ]
        ];

        foreach ($converters as $converter) {
            DB::table('converters')->insert($converter);
        }
    }
}
