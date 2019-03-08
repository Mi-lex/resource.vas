<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MiltaryDistrict extends Model
{
    public function objects() : HasMany
    {
       return $this->hasMany('App\Models\MiltaryObject', 'district_id');
    }
}
