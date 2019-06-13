<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    private $name_map = [
        'mercury_230' => 'Меркурий 230',
        'impis_12' => 'Импис 12',
        'logika_941' => 'Логика 941',
        'oven_si9' => 'Овен си9',
        'pulsar_2m' => 'Пульсар 2м',
        'logika_943' => 'Логика 943',
        'oven_si39' => 'Овен си30'
    ];

    public function russ_name()
    {
        return $this->name_map[$this->name];
    }
}
