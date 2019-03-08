<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MiltaryObject extends Model
{
    public function sectors() : HasMany
    {
        return $this->hasMany('App\Models\Sector', 'object_id');    
    }

    public function buildings() : HasMany
    {
        return $this->hasMany('App\Models\Building', 'object_id');    
    }

    public function meters_count() : int
    {
        return $this->buildings()->withCount('meters')->get()->sum('meters_count');  
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
