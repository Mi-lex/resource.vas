<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function buildings()
    {
        return $this->hasMany('App\Building', 'sector_id');
    }

    public function meters_count(string $type = null) : int
    {
        $count = $this->buildings->sum(function ($building) use ($type) {
            return $type ? 
                $building->special_meters($type)->count() : 
                $building->meters->count();
        });

        return $count;
    }

    public function consumption(string $type)
    {
        $sum = $this->buildings
            ->sum(function ($building) use ($type) {
                return $building->consumption($type);
        });

        return $sum;
    }
}
