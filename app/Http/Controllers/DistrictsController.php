<?php

namespace App\Http\Controllers;

use App\MiltaryDistrict;

class DistrictsController extends Controller
{
    public function show(MiltaryDistrict $district)
    {
        $objects = $district->objects;

        return view('pages.district', compact('objects'));
    }
}
