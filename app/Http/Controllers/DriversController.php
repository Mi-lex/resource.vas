<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Support\Facades\Log;

class DriversController extends Controller
{
    public function show(Meter $meter)
    {
        $driver_class = 'App\Drivers\\'.ucfirst($meter->driver->name);

        $driver = new $driver_class($meter);

        $result = $driver->collect_data();

        return response()->json($result);
    }

    public function params(Meter $meter)
    {
        $driver_class = 'App\Drivers\\'.ucfirst($meter->driver->name);

        $driver = new $driver_class($meter);

        $result = $driver->write_params();

        return response()->json($result);
    }

    public function write_electricity()
    {
        Meter::active()->ofType('electricity')->get()
            ->slice(2)
            ->each(function ($meter) {
                $driver = new \App\Drivers\Mercury_230($meter);

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
