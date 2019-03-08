<?php

namespace App\Http\Controllers;

use App\Models\Building;

class BuildingsController extends Controller
{
    public function show(Building $building)
    {
        return view('pages.building', compact('building'));
    }
}
