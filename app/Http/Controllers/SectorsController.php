<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;

class SectorsController extends Controller
{
    public function show(Sector $sector)
    {
        dd($sector);
    }
}