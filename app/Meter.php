<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Type;
use Carbon\Carbon;

class Meter extends Model
{
    private $consumption_attributes;

    public function __construct()
    {
        $this->consumption_attributes = [
            'electricity' => 
                ['id', 'created_at', 'device_id', 'sumDirectActive'],
            'water' => 
                ['id', 'created_at', 'device_id', 'consumption_amount'],
            'heat' => 
                ['id', 'created_at', 'device_id', 'thermal_energy']
        ];
    }

    public function consumptions($attributes = null)
    {
        $attributes = $attributes ?? '*';

        $model = 'App\\'.ucfirst($this->type->name).'Consumption';

        return $this->hasMany($model, 'device_id')
            ->select($attributes);
    }

    public function consumptions_by_days(int $days_count = 30)
    {
        $meter_type = $this->type->name;

        $consumptions = $this->consumptions($this->consumption_attributes[$meter_type])
            ->where('created_at', '>=', Carbon::now()->subDays($days_count)->startOfDay())
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('d-m-Y');
            })
            ->mapWithKeys(function ($item) {
                return [
                    Carbon::parse($item[0]['created_at'])->format('d-m-Y') => 
                        [$item->first(), $item->last()]
                ];
            });

        return $consumptions;
    }

    public function consumption_by_month(string $month) : int
    {
        $date = new Carbon($month);

        $main_consumption = end($this->consumption_attributes[$this->type->name]);
        
        $last_consumption = $this->consumptions()->select()
            ->where('created_at', '>=', $date->endOfMonth()->startOfDay())
            ->take(1)->get()->first();

        $start_consumption = $this->consumptions()->select()
            ->where('created_at', '>=', $date->startOfMonth()->startOfDay())
            ->take(1)->get()->first();

        $diff = $last_consumption[$main_consumption] - $start_consumption[$main_consumption];

        return $diff;
    }

    public function diff_consumption(int $days) : int {
        $start_date = Carbon::now()->subDays($days);

        $main_consumption = end($this->consumption_attributes[$this->type->name]);

        $last_consumption = $this->last_consumption($main_consumption);
        $start_consumption = $this->consumptions()->select($main_consumption)
            ->where('created_at', '>=', $start_date)
            ->take(1)->get()->first();

        $diff = $last_consumption[$main_consumption] - $start_consumption[$main_consumption];

        return $diff;
    }

    public function last_consumption($attr = null, bool $onlyAmount = false)
    {
        $last_consumption = $this->consumptions($attr)
            ->latest()->first();
        $consumptin_type = end($this->consumption_attributes[$this->type->name]);

        return $onlyAmount ? $last_consumption[$consumptin_type] : 
            $last_consumption;
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function scopeOfType($query, $type)
    {
        // can make it even better with joining tables
        return $query->where('type_id', Type::getIdByName($type));
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
