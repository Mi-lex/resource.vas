<?php

namespace App\Http\Controllers;

use App\Models\Meter;

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
}
