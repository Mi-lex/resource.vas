<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function sapper()
    {
        return view('games.sapper');    
    }
}
