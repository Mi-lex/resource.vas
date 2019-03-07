<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    static function getIdByName($name) {
        return self::withName($name)->get()->first()->id;
    }

    public function scopeWithName($query, $name) {
        return $query->where('name', $name);
    }
}
