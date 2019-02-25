<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;

class BuildingsController extends Controller
{
    public function show(Building $building)
    {
        return view('pages.building', compact('building'));
    }
}
