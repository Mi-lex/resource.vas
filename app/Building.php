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

    public function water_consumption()
    {
        $summ = $this->water_meters->sum(function ($meter) {
            $consumption_amount = $meter
                ->last_consumption('consumption_amount')['consumption_amount'];

            return $consumption_amount;
        });

        return $summ;
    }

    public function electricity_consumption()
    {
        $summ = $this->electricity_meters->sum(function ($meter) {
            $consumption_amount = $meter
                ->last_consumption('sumDirectActive')['sumDirectActive'];

            return $consumption_amount;
        });

        return $summ;
    }
}
