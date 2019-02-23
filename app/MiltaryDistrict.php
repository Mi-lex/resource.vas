<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiltaryDistrict extends Model
{
    public function objects()
    {
       return $this->hasMany('App\MiltaryObject', 'district_id');
    }
}
