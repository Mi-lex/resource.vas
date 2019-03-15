<?php

namespace App\Drivers;

use App\Abstracts\Driver;
use Illuminate\Support\Facades\Log;

class Mercury_230 extends Driver
{
    public function __construct($device)
    {
        parent::__construct($device);

        $this->connection_params['protocol'] = 'udp';
    }

    protected function crc_mbus(string $msg): string
    {
        $data = pack('H*', $msg);
        $crc = 0xFFFF;

        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= ord($data[$i]);

            for ($j = 8; $j != 0; $j--) {
                if (($crc & 0x0001) != 0) {
                    $crc >>= 1;
                    $crc ^= 0xA001;
                } else $crc >>= 1;
            }
        }
        $crc = sprintf('%04X', $crc);
        // меняем порядок байтов, как требует протокол
        $crc_inverted = substr($crc, 2, 2) . substr($crc, 0, 2);
        return $crc_inverted;
    }

    protected function get_clean_answer($answer): string
    {
        return substr($answer, 0, -4);
    }

    protected function prepare_command($str_command): string
    {
        $command = dechex($this->device->rs_port) . $str_command;

        $command = strtoupper($command . $this->crc_mbus($command));

        $command_hex = pack("H*", $command);

        return $command_hex;
    }

    private function test_connection(): bool
    {
        $testing_command = '00';
        $response = $this->make_request($testing_command);

        return !empty($response);
    }

    public function open_connection(): bool
    {
        // Значение пароля используется только в данном драйвере
        // кроме того, он одинаков для всех счетчиков
        // целесообразность хранить его в базе данных под вопросом
        Log::info('Открытие канала связи.');
        $password = '010101010101';
        $open_command = '0101' . $password;

        $response = $this->make_request($open_command);

        return strtoupper(substr($response, 0, 4)) ==
            strtoupper(dechex($this->device->rs_port) . "00");
    }

    private function calculate_power(string $power_str) : float
    {
        if ($power_str == "ffffffff") {
            return null;
        } else {
            return hexdec(substr($power_str, 2, 2)
                . substr($power_str, 0, 2)
                . substr($power_str, 6, 2)
                . substr($power_str, 4, 2)) * 0.001;
        }
    }

    private function write_power(int $command, array $attrs)
    {
        $power_command = '05000' . $command;

        $response = $this->make_request($power_command);

        if (strlen($response) === 38) {
            $chunk_response = str_split(substr($response, 2, -4), 8);

            $consumptions =
                array_map([$this, 'calculate_power'], $chunk_response);

            foreach ($attrs as $i => $attribute) {
                $this->consumption_record[$attribute] = $consumptions[$i];
            }
        }
    }

    private function write_consumption(): void
    {
        // Записываем суммарные данные потреблений
        $summ_command = 0;
        $summ_attributes = [
            'sumDirectActive',
            'sumInverseActive',
            'sumDirectReactive',
            'sumInverseReactive'
        ];

        $this->write_power($summ_command, $summ_attributes);

        // Записываем отдельные показатели по каждому тарифу
        $tariff_commands = [1, 2, 3, 4];

        foreach ($tariff_commands as $t) {
            $this->write_power($t, [
                "t$t" . 'DirectActive',
                "t$t" . 'InverseActive',
                "t$t" . 'DirectReactive',
                "t$t" . 'InverseReactive',
            ]);
        }
    }

    public function collect_data()
    {
        if ($this->test_connection()) {
            Log::info('Канал связи успешно протестирован.');

            if ($this->open_connection()) {
                Log::info('Канал связи открыт');

                // Записываем показатели счетчика в свойство объекта
                $this->write_consumption();

                return $this->consumption_record;
            } else {
                Log::error('Канал связи не открыт.');
                return false;
            }
        } else {
            Log::error('Канал связи не прошел тест.');
            return false;
        }
    }
}
