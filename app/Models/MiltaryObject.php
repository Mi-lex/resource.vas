<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MiltaryObject extends Model
{
    /**
     * Возвращает военные городки,
     * принадлежащие данному военному объекту
     * 
     * @return HasMany - коллекция объектов городков
     */
    public function sectors() : HasMany
    {
        return $this->hasMany('App\Models\Sector', 'object_id');    
    }

    /**
     * Здания, принадлежащие данному
     * военному объекту
     *
     * @return HasMany - коллекция зданий
     */
    public function buildings() : HasMany
    {
        return $this->hasMany('App\Models\Building', 'object_id');    
    }

    public function meters_count() : int
    {
        // кол-во счетчиков объекта
        return $this->buildings()->withCount('meters')->get()->sum('meters_count');  
    }

    /**
     * Суммирует нынешнее потребление ресурсов
     * по объекту
     *
     * @param string $type - тип потребления
     * @return integer - сумма потреблений
     * (напр. n кВт)
     */
    public function consumption(string $type) : int
    {
        $sum = $this->buildings
            ->sum(function ($building) use ($type) {
                return $building->consumption($type);
        });

        return $sum;
    }
}
