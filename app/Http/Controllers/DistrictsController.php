<?php

namespace App\Http\Controllers;

use App\Models\MiltaryDistrict;

class DistrictsController extends Controller
{
    public function show(MiltaryDistrict $district)
    {
        if ($district && $district->objects()->exists()) {
            $objects = $district->objects;

           return view('pages.district', compact('objects'));
        } else {
            return view('pages.underdevelopment');
        }
    }
}
