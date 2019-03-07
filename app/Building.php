<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $timestamps = false;

    public function meters()
    {
        return $this->hasMany('App\Meter');
    }

    public function special_meters($type)
    {
        return $this->meters()->ofType($type);
    }

    public function consumption(string $type) : ?int
    {
        $sum = $this->special_meters($type)->get()->sum(function ($meter) {
            return $meter->last_consumption(null, true);
        });

        return $sum;
    }
}
