<?php

namespace App\Http\Controllers;

use App\Meter;
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

    public function show(Meter $meter)
    {
        $current_consumption = $meter
            ->{$this->type_methods[$meter->type->name]}()
            ->latest()->first();
        
        // dd($current_consumption->t1DirectReactive);

        return view('meters.' . $meter->type->name, compact('meter', 'current_consumption'));
    }

    public function consumption(Meter $meter, int $days)
    {
        $meter_type = $meter->type->name;

        $consumptions = $meter->{$this->type_methods[$meter_type]}()
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('d');
            })->toArray();
            
            // ->mapWithKeys(function ($row) {
            //     return [$row['created_at'] => array_slice()]
            // });

        return response()->json($consumptions);
    }
}
