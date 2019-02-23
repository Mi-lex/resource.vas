<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MiltaryDistrict;

class DistrictsController extends Controller
{
    public function show(MiltaryDistrict $district)
    {
        $objects = $district->objects;

        return view('pages.district', 'objects');
    }
}
