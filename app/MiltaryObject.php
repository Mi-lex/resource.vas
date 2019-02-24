<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiltaryObject extends Model
{
    public function sectors()
    {
        return $this->hasMany('App\Sector', 'object_id');    
    }

    public function buildings()
    {
        return $this->hasMany('App\Building', 'object_id');    
    }

    public function meters_count()
    {
        return $this->buildings()->withCount('meters')->get()->sum('meters_count');  
    }

    public function water_consumption()
    {
        $sum = $this->buildings->sum(function ($building) {
            return $building->water_consumption();
        });

        return $sum;
    }

    public function electricity_consumption()
    {
        $sum = $this->buildings->sum(function ($building) {
            return $building->electricity_consumption();
        });

        return $sum;
    }
}
