<?php

namespace App\Http\Controllers;

use App\Models\Meter;

class DriversController extends Controller
{
    public function show(Meter $meter)
    {
        $driver_class = 'App\Drivers\\'.ucfirst($meter->driver->name);

        $driver = new $driver_class($meter);

        // $result = $driver->collect_data();
        $result = $driver->write_params();

        // dd($result);

        // $driver->write_to_db();

        return response()->json($result);
    }
}
