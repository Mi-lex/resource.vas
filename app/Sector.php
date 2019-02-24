<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function buildings()
    {
        return $this->hasMany('App\Building', 'sector_id');
    }

    public function meters_count($type = null)
    {
        $method = $type ? $type.'_' : '';

        $count = $this->buildings->sum(function ($building) use ($method) {
            return $building->{$method.'meters'}()->count();
        });

        return $count;
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
