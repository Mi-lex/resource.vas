<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    private $typesConsumptions;

    public function __construct()
    {
        $this->typesConsumptions = [
            'electric' => 'App\ElectricityConsumption',
            'water'    => 'App\WaterConsumption',
            'heat'     => 'App\HeatConsumption',
        ];
    }

    public function consumptions($attributes = null)
    {
        $attributes = $attributes ?? '*';

        $type = $this->type->name;

        return $this->hasMany($this->typesConsumptions[$type], 'device_id')
            ->select($attributes);
    }

    public function last_consumption($attr = null)
    {
        return $this->consumptions($attr)
            ->latest()->first();
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }
}
