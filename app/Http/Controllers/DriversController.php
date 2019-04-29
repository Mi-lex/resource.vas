<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Support\Facades\Log;

class DriversController extends Controller
{
    public function show(Meter $meter)
    {
        $driver_class = $meter->driver_class;

        $driver = new $driver_class($meter);

        $result = $driver->collect_data();

        return response()->json($result);
    }

    public function params(Meter $meter)
    {
        $driver = $meter->driver_instance();

        $result = $driver->write_params();

        return response()->json($result);
    }

    public function write($type)
    {
        Meter::active()->ofType($type)->get()
            // ->slice(2) // for not working electricity meters
            ->each(function ($meter) {
                $driver = $meter->driver_instance();

                $result = $driver->collect_data();

                if ($result) {
                    $driver->write_to_db();
                    Log::info('Electricity consumption written successfully');
                } else {
                    Log::error('The consumption wasnt collected. There must be something wrong with connection');
                }
            });

        return 'Done';  
    }
}
