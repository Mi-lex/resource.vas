<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Http\Request;

class MetersController extends Controller
{
    public function show(Meter $meter)
    {
        $current_consumption = $meter->last_consumption();

        return view('meters.' . $meter->type->name, compact('meter', 'current_consumption'));
    }

    public function consumption(Meter $meter, int $days)
    {
        $consumptions = $meter->consumptions_by_days($days);

        return response()->json($consumptions);
    }

    public function metersValues(Request $request)
    {
        $meters_values = [];

        foreach ($request->meters as $meter_id) {
            try {
                $main_value = Meter::find($meter_id)
                    ->connect_device()
                    ->get_main_value();
                if ($main_value) {
                    $meters_values[$meter_id] = $main_value;
                }
            } catch (\Throwable $th) {
                $meters_values[$meter_id] = 0;
            }
        }

        return $meters_values;
    }

    public function last_electricity_consumption(Meter $meter)
    {
        $columns = [
            'id', 'created_at', 'device_id', 't1DirectActive',
            't1DirectReactive', 't2DirectActive', 't2DirectReactive'
        ];

        $last_consumption = $meter
            ->consumptions()
            ->select($columns)
            ->latest()
            ->first();

        return response()->json($last_consumption);
    }

    public function last_consumption(Meter $meter)
    {
        return response()->json($meter->last_consumption());
    }

    public function monitoring(Meter $meter)
    {
        return view('monitoring.' . $meter->driver->name, compact('meter'));
    }

    public function observe()
    {
        return view('pages.observing');
    }
}