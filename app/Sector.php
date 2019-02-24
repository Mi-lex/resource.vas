<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function buildings()
    {
        return $this->hasMany('App\Building', 'sector_id');    
    }
}
