<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    public function electricity_consumptions()
    {
        return $this->hasMany('App\ElectricityConsumption', 'device_id');
    }

    public function water_consumptions()
    {
        return $this->hasMany('App\WaterConsumption', 'device_id');
    }

    public function heat_consumptions()
    {
        return $this->hasMany('App\HeatConsumption', 'device_id');
    }

    public function type(){
        return $this->belongsTo('App\Type');
    }
}
