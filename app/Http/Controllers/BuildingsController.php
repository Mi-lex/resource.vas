<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Meter;

class BuildingsController extends Controller
{
    public function show(Building $building)
    {
        return view('pages.building', compact('building'));
    }

    public function list()
    {
        $building = Building::all()->each(function ($building) {
            $building->meters_arr = Meter::whereBuildingId($building->id)
                ->select('meters.*', 'types.name as typeName')
                ->leftJoin('types', 'meters.type_id', '=', 'types.id')->get();
        });

        return $building;
    }
}