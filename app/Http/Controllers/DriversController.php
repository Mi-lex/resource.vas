<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use Illuminate\Support\Facades\Log;

class DriversController extends Controller
{
    public function show(Meter $meter)
    {
        $consumption_data = $meter
            ->connect_device()
            ->collect_data();

        return response()->json($consumption_data);
    }

    public function params(Meter $meter)
    {
        $device_params = $meter
            ->connect_device()
            ->write_params();

        return $device_params;
    }

    /**
     * Записывает значения потребления
     * указанного типа в базу данных
     *
     * @param [type] $type - тип потребления
     * @return void
     */
    public function write($type)
    {
        Meter::active()->ofType($type)->get()
            ->each(function ($meter) {
                try {
                    $device = $meter->connect_device();

                    $consumption_data = $device->collect_data();

                    if ($consumption_data) {
                        $device->write_to_db();

                        Log::info(ucfirst($meter->type->name) . ' consumption written successfully');
                    } else {
                        Log::error('The consumption wasnt collected. There must be something wrong with connection');
                    }
                } catch (\Throwable $th) {
                    Log::error('The record wasn\'t written in db. Meter: ' . $meter->id);
                }
            });

        return 'Done';
    }
}