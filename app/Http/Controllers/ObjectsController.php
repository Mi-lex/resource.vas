<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MiltaryObject;

class ObjectsController extends Controller
{
    public function show(MiltaryObject $object)
    {
        return view('pages.object', compact('object'));
    }
}
