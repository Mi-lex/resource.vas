<?php

use Illuminate\Database\Seeder;

class MetersChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meters_channels = [
            [
                'meter_id' => '23',
                'channel' => 2
            ],
            [
                'meter_id' => '21',
                'channel' => 1
            ],
            [
                'meter_id' => '18',
                'channel' => 2
            ],
            [
                'meter_id' => '17',
                'channel' => 0
            ],
            [
                'meter_id' => '20',
                'channel' => 3
            ],
            [
                'meter_id' => '19',
                'channel' => 1
            ]
        ];

        foreach ($meters_channels as $meter_channel) {
            DB::table('meters_channels')->insert($meter_channel);
        }
    }
}
