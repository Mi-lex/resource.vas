<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Meter extends Model
{
    protected $dates = ['verification_date'];
    private $consumption_attributes;

    const UPDATED_AT = null;

    public function __construct()
    {
        // Основная информация о потреблении
        $this->consumption_attributes = [
            'electricity' =>
            ['id', 'created_at', 'device_id', 'sumDirectActive'],
            'water' =>
            ['id', 'created_at', 'device_id', 'consumption_amount'],
            'heat' =>
            ['id', 'created_at', 'device_id', 'thermal_energy']
        ];
    }

    /**
     * Возвращает записи потреблений, принадлежащих
     * данному устройству
     *
     * @param array|string|null $attributes - информация о потрблении,
     * которую необходимо извлечь
     * @return HasMany - объекты потреблений устройства
     */
    public function consumptions($attributes = null): HasMany
    {
        // если атрибуты не указаны, выбрать все
        $attributes = $attributes ?? '*';

        // выбирает класс модели потребления согласно ти
        $model = 'App\Models\\' . ucfirst($this->type->name) . 'Consumption';

        return $this->hasMany($model, 'device_id')
            ->select($attributes);
    }

    /**
     * Выводит ежедневную информацию о расходе ресурсов
     * (используется для построения графика)
     * 
     * @param integer $days_count - количество дней
     * (предшествующих настоящему), информация о расходах
     * которых нам необходима
     * @return object $consumptions - объект, ключи которого - это
     * даты дней. Значения ключей - массив, содержащий два объекта:
     *  1) Информация о потреблении на начало дня
     *  2) Информация о потреблении на конец дня
     */
    public function consumptions_by_days(int $days_count = 30): object
    {
        $meter_type = $this->type->name;
        $attributes = $this->consumption_attributes[$meter_type];
        // извлекаем потребление данного устройства
        $consumptions = $this->consumptions($attributes)
            // только позднее даты: наст.время - кол-во дней
            ->where('created_at', '>=', Carbon::now()->subDays($days_count)->startOfDay())
            // получаем коллекцию потреблений за каждый час
            ->get()
            // группируем потребления по дням
            ->groupBy(function ($consumption) {
                return Carbon::parse($consumption->created_at)->format('d-m-Y');
            })
            // оставляем первое и последнее потребления за день
            ->map(function ($dayly_consumption) {
                return [$dayly_consumption->first(), $dayly_consumption->last()];
            });

        return $consumptions;
    }

    /**
     * Определяет первое и последнее значение потребления
     * на указанный месяц. Вовзращает разницу
     *
     * @param string $month - имя месяц (april, march etc)
     * @return integer $diff - расход за месяц
     */
    public function month_consumption(string $month): int
    {
        $date = new Carbon($month);
        /**
         * Т.к необходимо только число. Извлекаем информацию только об основном
         * расходе (без дат, други параметров и.т.д)
         */
        $main_consumption = end($this->consumption_attributes[$this->type->name]);

        $start_consumption = $this->consumptions($main_consumption)
            ->after($date->startOfMonth()->startOfDay())->take(1)->get()->first();

        $last_consumption = $this->consumptions($main_consumption)
            ->after($date->endOfMonth()->startOfDay())->take(1)->get()->first();

        $diff = $last_consumption[$main_consumption] - $start_consumption[$main_consumption];

        return $diff;
    }

    /**
     * Вычисляет расход ресурсов за последние дни
     *
     * @param integer $days - кол-во дней
     * @return integer $diff - расход ресурсов
     */
    public function diff_consumption(int $days): int
    {
        $start_date = Carbon::now()->subDays($days);

        $main_consumption = end($this->consumption_attributes[$this->type->name]);

        $start_consumption = $this->consumptions($main_consumption)
            ->after($start_date)->take(1)->get()->first();
        $last_consumption = $this->last_consumption($main_consumption);

        $diff = $last_consumption[$main_consumption] - $start_consumption[$main_consumption];

        return $diff > 0 ? $diff : 0;
    }

    /**
     * Определяет последнее значения счетчика
     *
     * @param string|array $attr - информация о потреблении
     * @param boolean $onlyValue - только числовое значение
     * @return object|int - объект потребления или числовое
     * значение
     */
    public function last_consumption($attr = null, bool $onlyValue = false)
    {
        // $this->write_actual_consumption();

        $last_consumption = $this->consumptions($attr)
            ->latest()->first();

        // if there is no consumption create it
        if (is_null($last_consumption)) {
            $last_consumption = $this->consumptions()->create();
        }

        $consumption_type = end($this->consumption_attributes[$this->type->name]);

        return $onlyValue ? $last_consumption[$consumption_type] : $last_consumption;
    }

    public function full_device_name(): string
    {
        return 'Импульсный счетчик ' . $this->driver->russ_name;
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function channel(): ?string
    {
        $channel = \DB::table('meters_channels')->whereMeterId($this->id)->first();

        return $channel->channel;
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo('App\Models\Driver');
    }

    public function driver_instance()
    {
        $driver_class = 'App\Drivers\\' . ucfirst($this->driver->name);

        $driver = new $driver_class($this);

        return $driver;
    }

    public function converter()
    {
        return $this->belongsTo('App\Models\Converter');
    }

    public function scopeOfType($query, string $type): Builder
    {
        return $query
            ->select('meters.*')
            ->leftJoin('types', 'meters.type_id', '=', 'types.id')
            ->where('types.name', '=', $type);
    }

    public function scopeActive($query): Builder
    {
        return $query->whereActive(true);
    }

    private function write_actual_consumption()
    {
        $driver = $this->driver_instance();

        $driver->collect_data();
        $driver->write_to_db();
    }
}