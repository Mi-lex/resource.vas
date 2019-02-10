<?php

namespace App\Http\Controllers;

use App\Meter;

use Illuminate\Http\Request;

class MetersController extends Controller
{
    public function show(Meter $meter)
    {
        return view('meters.' . $meter->type->name, compact('meter'));
    }
}
