<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectricityConsumption extends Model
{
    public $timestamps = false;
    //
    protected $table = 'electricity_consumptions';
}
