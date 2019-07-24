<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MiltaryDistrictsTableSeeder::class);
        $this->call(MiltaryObjectsTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(BuildingsTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(DriversTableSeeder::class);
        $this->call(ConvertersTableSeeder::class);
        // $this->call(MetersTableSeeder::class);
        // $this->call(ElectricityConsumptionsTableSeeder::class);
        // $this->call(WaterConsumptionsTableSeeder::class);
        // $this->call(MetersChannelsTableSeeder::class);
        
    }
}
