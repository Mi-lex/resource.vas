<?php

namespace App\Traits;

trait Consumption
{
    public function scopeFirstAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }
}