<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    static function getIdByName(string $name) : int
    {
        return self::withName($name)->get()->first()->id;
    }

    public function scopeWithName($query, string $name) 
    {
        return $query->where('name', $name);
    }
}
