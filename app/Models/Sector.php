<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    public function buildings() : HasMany
    {
        return $this->hasMany('App\Models\Building', 'sector_id');
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

    public function consumption(string $type) : int
    {
        $sum = $this->buildings
            ->sum(function ($building) use ($type) {
                return $building->consumption($type);
        });

        return $sum;
    }
}
