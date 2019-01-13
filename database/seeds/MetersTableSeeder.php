<?php

use Illuminate\Database\Seeder;

class MetersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meters = [
            // Electrometers
            [
                'name' => 'Тестовый стенд',
                'model' => 'Меркурий 230 AR-01 R',
                'serial_number' => 32388364,
                'description' => 'Счётчик с тестового макета',
                'active' => false,
                'server_ip' => '10.155.171.57',
                'server_port' => '40000',
                'rs_port' => 64,
                'meter_pass' => 010101010101
            ],
            [
                'name' => 'ЦОД  основной ввод',
                'model' => 'Меркурий 230 ART-03 RN',
                'serial_number' => 31,
                'description' => 'Счётчик технического учёта энергии, 
                    потребляемой ЦОД ЦОИ через основной энерговвод',
                'active' => true,
                'server_ip' => '10.155.171.187',
                'server_port' => '40000',
                'rs_port' => 31,
                'meter_pass' => 010101010101
            ],
            [
                'name' => 'ЦОД  резервный ввод',
                'model' => 'Меркурий 230 ART-03 RN',
                'serial_number' => 94,
                'description' => 'Счётчик технического учёта энергии, потребляемой ЦОД ЦОИ через резервный энерговвод',
                'active' => true,
                'server_ip' => '10.155.171.187',
                'server_port' => '40000',
                'rs_port' => 94,
                'meter_pass' => 010101010101
            ],
            [
                'name' => 'Аварийная панель 5',
                'model' => 'Мерукрий 234',
                'serial_number' => 21748622,
                'description' => 'Счётчик в ГРЩ панель 5',
                'active' => true,
                'server_ip' => '10.154.107.100',
                'server_port' => '40000',
                'rs_port' => 22,
                'meter_pass' => 010101010101
            ],
            [
                'name' => 'Распределительная панель 4',
                'model' => 'Мерукрий 234',
                'serial_number' => 21747639,
                'description' => 'Счётчик в ГРЩ панель 4',
                'active' => true,
                'server_ip' => '10.154.107.100',
                'server_port' => '40000',
                'rs_port' => 39,
                'meter_pass' => 010101010101
            ],
            [
                'name' => 'Распределительная панель 2',
                'model' => 'Мерукрий 234',
                'serial_number' => 21747340,
                'description' => 'Счётчик в ГРЩ панель 4',
                'active' => true,
                'server_ip' => '10.154.107.100',
                'server_port' => '40000',
                'rs_port' => 40,
                'meter_pass' => 010101010101
            ],
            // WaterMeters
            [
                'name' => "ВУ-29 ГП-1 основной",
                'active' => true,
                'description' => "Внутренняя хозбытовая линия ГП-1 со стороны ТСО рабочая ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "13563266",
                'server_ip' => "10.155.169.240",
                'server_port' => "40000",
                'rs_port' => "01",
              ],
              [
                'name' => "ВУ-25 ГП-2 основной",
                'active' => false,
                'description' => "Внутренняя хозбытовая линия ГП-2 рабочая ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "14540377",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-26 ГП-2 резервный",
                'active' => false,
                'description' => "Внутренняя хозбытовая линия ГП-2 резервная ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "14540397",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "Тестовый стенд Пульсар 80 канал 2",
                'active' => false,
                'description' => "Тест Пульсар",
                'model' => "тест",
                'serial_number' => null,
                'server_ip' => "10.155.171.57",
                'server_port' => "40000",
                'rs_port' => "00974280",
              ],
              [
                'name' => "Тестовый стенд Пульсар 80 канал 1",
                'active' => false,
                'description' => "Тест Пульсар",
                'model' => "тест",
                'serial_number' => null,
                'server_ip' => "10.155.171.57",
                'server_port' => "40000",
                'rs_port' => "00974280",
              ],
              [
                'name' => "ВУ-1 ГП-2 хозбытовой",
                'active' => false,
                'description' => "Ввод РСО хозбытовая ветка ГП-2",
                'model' => "WPH-ZF",
                'serial_number' => "13054984",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-1 ГП-2 пожарный",
                'active' => false,
                'description' => "Ввод РСО пожарная ветка ГП-2",
                'model' => "WPH-ZF",
                'serial_number' => "13005020",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-30 ГП-1 резервный",
                'active' => false,
                'description' => "Внутренняя хозбытовая линия ГП-1 со стороны ТСО резервная ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "13563154",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => "01",
              ],
              [
                'name' => "ВУ-8 ГП-8",
                'active' => false,
                'description' => "Ввод РСО неопределённая ветка ГП-8",
                'model' => "WPH-ZF",
                'serial_number' => "13527210",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-8 ГП-8",
                'active' => false,
                'description' => "Ввод РСО неопределённая ветка ГП-8",
                'model' => "WPH-ZF",
                'serial_number' => "13526427",
                'server_ip' => null,
                'server_port' => null,
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-6 ГП-5 хозбытовая",
                'active' => true,
                'description' => "Ввод РСО рабочий со стороны КПП хозбытовая ветка ГП-5",
                'model' => "ВСХНд-40",
                'serial_number' => "14557174",
                'server_ip' => "10.154.91.100",
                'server_port' => "40000",
                'rs_port' => "00974280",
              ],
              [
                'name' => "ВУ-6 ГП-5 пожарная",
                'active' => false,
                'description' => "Ввод РСО рабочий со стороны КПП пожарная ветка ГП-5",
                'model' => "ВСХНд-80",
                'serial_number' => "12563068",
                'server_ip' => "10.154.91.100",
                'server_port' => "40000",
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-7 ГП-5 хозбытовая",
                'active' => true,
                'description' => "Ввод РСО резервный со стороны поликлиники хозбытовая ветка ГП-5",
                'model' => "ВСХНд-40",
                'serial_number' => "14557205",
                'server_ip' => "10.154.91.100",
                'server_port' => "40000",
                'rs_port' => "00974280",
              ],
              [
                'name' => "ВУ-7 ГП-5 пожарная",
                'active' => false,
                'description' => "Ввод РСО резервный со стороны поликлиники пожарная ветка ГП-5",
                'model' => "ВСХНд-80",
                'serial_number' => "12536428",
                'server_ip' => "10.154.91.100",
                'server_port' => "40000",
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-5 ГП-4 хозбытовая",
                'active' => true,
                'description' => "Ввод РСО рабочий со стороны поликлиники хозбытовая ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "14557208",
                'server_ip' => "10.154.87.100",
                'server_port' => "40000",
                'rs_port' => "00974269",
              ],
              [
                'name' => "ВУ-5 ГП-4 пожарная",
                'active' => false,
                'description' => "Ввод РСО рабочий со стороны поликлиники пожарная ветка",
                'model' => "ВСХНд-80",
                'serial_number' => "12536436",
                'server_ip' => "10.154.87.100",
                'server_port' => "40000",
                'rs_port' => null,
              ],
              [
                'name' => "ВУ-4 ГП-4 хозбытовая",
                'active' => true,
                'description' => "Ввод РСО резервный со стороны УЛК хозбытовая ветка",
                'model' => "ВСХНд-40",
                'serial_number' => "14561389",
                'server_ip' => "10.154.87.100",
                'server_port' => "40000",
                'rs_port' => "00974269",
              ],
              [
                'name' => "ВУ-4 ГП-4 пожарная",
                'active' => false,
                'description' => "Ввод РСО резервный со стороны УЛК пожарная ветка",
                'model' => "ВСХНд-80",
                'serial_number' => "12563082",
                'server_ip' => "10.154.87.100",
                'server_port' => "40000",
                'rs_port' => null
              ],

              // Heat meters
              [
                'name' => "Тепловой ввод ГП-1",
                'active' => true,
                'description' => "Главный тепловой ввод ГП-1",
                'model' => "Логика СПТ943",
                'server_ip' => "10.155.169.241",
                'server_port' => "40000",
              ],
              [
                'name' => "Тестовый стенд",
                'active' => false,
                'description' => "Тестовый счётчик",
                'model' => "Логика СПТ941",
                'serial_number' => "123456",
                'server_ip' => "10.155.168.49",
                'server_port' => "4001",
              ],
        ];

        foreach ($meters as $meter) {
            DB::table('meters')->insert($meter);
        }
    }
}
