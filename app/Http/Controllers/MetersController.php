<?php

namespace App\Http\Controllers;

use App\Meter;
use App\Building;
use Carbon\Carbon;

use Illuminate\Http\Request;

class MetersController extends Controller
{
    // map for using relavant methods
    private $type_methods = [
        'electric' => 'electricity_consumptions',
        'water' => 'water_consumptions',
        'heat' => 'heat_consumptions'
    ];

    private $consumption_attributes = [
        'electricity_consumptions' => 
            ['id', 'created_at', 'device_id', 'sumDirectActive'],
        'water_consumptions' => null
           ,
        'heat_consumptions' => null
    ];

    public function show(Meter $meter)
    {
        $current_consumption = $meter->last_consumption();
        
        return view('meters.'.$meter->type->name, compact('meter', 'current_consumption'));
    }

    public function consumption(Meter $meter, int $days)
    {
        $meter_type = $meter->type->name;

        $consumption_type = $this->type_methods[$meter_type];

        $consumptions = $meter->consumptions($this->consumption_attributes[$consumption_type])
            ->where('created_at', '>=', Carbon::now()->subDays($days)->startOfDay())
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('d');
            })
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item[0]['created_at'])->format('d-m-Y') => 
                    [$item->first(), $item->last()]];
            });

        return response()->json($consumptions);
    }

    public function last_electricity_consumption(Meter $meter)
    {
        $columns = ['id', 'created_at', 'device_id', 't1DirectActive', 
            't1DirectReactive', 't2DirectActive', 't2DirectReactive'];

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
}
