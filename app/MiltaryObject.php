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

    public function consumption(string $type)
    {
        $sum = $this->buildings
            ->sum(function ($building) use ($type) {
                return $building->consumption($type);
        });

        return $sum;
    }
}
