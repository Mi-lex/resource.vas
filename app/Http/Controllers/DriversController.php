<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Support\Facades\Log;

class DriversController extends Controller
{
    public function show(Meter $meter)
    {
        $driver = $meter->driver_instance();

        $result = $driver->collect_data();

        return response()->json($result);
    }

    public function params(Meter $meter)
    {
        $driver = $meter->driver_instance();

        $result = $driver->write_params();

        return response()->json($result);
    }

    /**
     * Записывает значения потребления
     * указанного типа в базу данных
     *
     * @param [type] $type - тип потребления
     * @return void
     */
    public function write($type)
    {
        Meter::active()->ofType($type)->get()
            // ->slice(2) // for not working electricity meters
            ->each(function ($meter) {
                $driver = $meter->driver_instance();

                $result = $driver->collect_data();

                if ($result) {
                    $driver->write_to_db();

                    Log::info(ucfirst($meter->type->name).' consumption written successfully');
                } else {
                    Log::error('The consumption wasnt collected. There must be something wrong with connection');
                }
            });

        return 'Done';  
    }
}
