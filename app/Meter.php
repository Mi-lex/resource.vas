<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meter extends Model
{
    private $type_names;

    private $typesConsumptions;

    private $consumption_attributes;

    public function __construct()
    {
        $this->typesConsumptions = [
            'electricity' => 'App\ElectricityConsumption',
            'water'    => 'App\WaterConsumption',
            'heat'     => 'App\HeatConsumption',
        ];

        $this->consumption_attributes = [
            'electricity' => 
                ['id', 'created_at', 'device_id', 'sumDirectActive'],
            'water' => 
                ['id', 'created_at', 'device_id', 'consumption_amount'],
            'heat' => 
                ['id', 'created_at', 'device_id', 'thermal_energy']
        ];

        $this->type_names = [
            'electricity' => '1',
            'water' => '2',
            'heat' => '3'
        ];
    }

    public function consumptions($attributes = null)
    {
        $attributes = $attributes ?? '*';

        $type = $this->type->name;

        return $this->hasMany($this->typesConsumptions[$type], 'device_id')
            ->select($attributes);
    }

    public function consumptions_by_days(int $days_count = 30)
    {
        $meter_type = $this->type->name;

        $consumptions = $this->consumptions($this->consumption_attributes[$meter_type])
            ->where('created_at', '>=', Carbon::now()->subDays($days_count)->startOfDay())
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('d');
            })
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item[0]['created_at'])->format('d-m-Y') => 
                    [$item->first(), $item->last()]];
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

    public function scopeOfType($query, $type_number)
    {
        return $query->where('type_id', $this->type_names[$type_number]);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
