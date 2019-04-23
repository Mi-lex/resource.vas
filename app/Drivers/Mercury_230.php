<?php

namespace App\Drivers;

use App\Abstracts\Driver;
use Illuminate\Support\Facades\Log;

class Mercury_230 extends Driver
{
    private $params_record;
    private $params_commands;

    public function __construct($device)
    {
        parent::__construct($device);

        $this->connection_params['protocol'] = 'udp';

        $this->params_record = [];

        $this->params_commands = [
            'full_power' => [
                'operation' => '081608',
                'symbol'  => 's',
                'mask'    => 0x3fffff,
                'with_sum' => true
            ],
            'active_power' => [
                'operation' => '081600',
                'symbol'  => 'p',
                'mask'    => 0x3fffff,
                'with_sum' => true
            ],
            'reactive_power' => [
                'operation' => '081604',
                'symbol'  => 'q',
                'mask'    => 0x3fffff,
                'with_sum' => true
            ],
            'voltage' => [
                'operation' => '081611',
                'symbol'  => 'u',
                'mask'    => 0xffffff
            ],
            'amperage' => [
                'operation' => '081621',
                'symbol'  => 'i',
                'ratio'   => 0.001,
                'mask'    => 0xffffff
            ],
            'coefficient_power' => [
                'operation' => '081631',
                'symbol'  => 'phi',
                'ratio'   => 0.001,
                'mask'    => 0x3fffff
            ],
            'network_frequency' => [
                'operation' => '081140',
                'symbol'  => 'f',
                'mask'    => 0x3fffff,
                'with_sum' => true
            ]
        ];
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

    private function calculate_power(string $power_str): ?float
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

    public function connection_wrapper(callable $operation)
    {
        if ($this->test_connection()) {
            Log::info('Канал связи успешно протестирован.');

            if ($this->open_connection()) {
                Log::info('Канал связи открыт');

                $operation();
            } else {
                Log::error('Канал связи не открыт.');
                return false;
            }
        } else {
            Log::error('Канал связи не прошел тест.');
            return false;
        }
    }

    public function collect_data()
    {
        $this->connection_wrapper(function() {
            // Записываем показатели счетчика в свойство объекта
            $this->write_consumption();
        });

        return $this->consumption_record;
    }

    /**
     * Принимает строку шестнадцаатеричных данных,
     * разделяет ее на блоки. Возвращает
     * блоки в виде массива
     * 
     * @param string $param_str строка шестнадцатеричных данных
     * @return array массив смысловых блоков
     */
    private function parse_param(string $param_str) : array
    {
        // remove two first elements and split str into arra
        $param_arr = str_split(substr($param_str, 2), 6);

        $parser = function($el) {
            if (strlen($el) < 6) {
                return $el;
            } else {
                return substr($el, 0, 2).substr($el, 4, 2).substr($el, 2, 2);
            }
        };
        // get correct results accroting to protocol
        $result = array_map($parser, $param_arr);

        return array_slice($result, 0, 4);
    }

    /**
     * Отправляет команду устройству,
     * принимает ответ и парсит значения в массив
     *
     * @param array $command  массив, содержащий информацию
     * о параметре, команде для его получения и т.д.
     * @return array $result  массив посчитанных параметров
     */
    private function get_param(array $command) : array
    {
        $unparsed_param = $this->make_request($command['operation']);

        $param_arr = $this->parse_param($unparsed_param);

        $result = [];

        foreach ($param_arr as $i => $value) {
            $index = isset($command['with_sum']) ? $i : $i + 1;

            $row_name = $command['symbol'] . ($index == 0 ? '' : $index); // f.e S, S1 ...

            $calc_value = (hexdec($value) & $command['mask']) * ($command['ratio'] ?? 0.01);

            $result[$row_name] = $calc_value;
        }

        return $result;
    }

    public function write_params()
    {
        $this->connection_wrapper(function() {
            // Записываем показатели счетчика в свойство объекта
            foreach ($this->params_commands as $command) {
                $params = $this->get_param($command);
                $this->params_record = array_merge($this->params_record, $params);
            }
        });

        return $this->params_record;
    }
}
