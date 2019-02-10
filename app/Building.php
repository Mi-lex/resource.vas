<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public function meters()
    {
        return $this->hasMany('App\Meter');
    }

    public function electricity_meters()
    {
        return $this->meters()->where('type_id', 1);
    }

    public function water_meters()
    {
        return $this->meters()->where('type_id', 2);
    }

    public function heat_meters()
    {
        return $this->meters()->where('type_id', 3);
    }
}
