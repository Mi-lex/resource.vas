<?php

namespace App\Abstracts;

use App\Socket\Socket;
use Illuminate\Support\Facades\Log;

abstract class Driver {
    protected $device;
    protected $connection_params;
    protected $consumption_record;

    public function __construct($device)
    {
        $this->device = $device;

        $this->connection_params['ip'] = $device->server_ip;
        $this->connection_params['port'] = $device->server_port;    
    }

    // Принимает HEX данные и возвращает строку для отображения
    protected function nice_hex(string $str) : string
    {
        // Проверить правильность работы с двумя аргументами
        $unpacked_str = unpack('H*', $str, null);

        // почему берется первый элемент ??
        return strtoupper(implode(' ', str_split($unpacked_str[1], 2)));
    }

    // Принимает строку с HEX данными и возвращает строку для отображения
    protected function nice_hex_string(string $str) : string
    {
        return strtoupper(implode(' ', str_split($str, 2)));
    }

    // Принимает данные и возвращает CRC16 стандарта XMODEM в виде HEX строки
    protected function crc_mbus(string $msg) : string {
        return $msg;
    }

    // Функция извлечения подстроки из ответа для вычисления контрольной суммы
    protected function get_clean_answer(string $answer) : string {
        return $answer;
    }

    protected function crc_right(string $answer = '') : bool
    {
        $unpacked_answer = unpack('H*', $answer, null)[1];

        $received_crc = strtoupper(substr($unpacked_answer, -4));

        // Необходимо обработать строку для каждого счетчика по-своему
        $clean_answer = $this->get_clean_answer($unpacked_answer);
        $calculated_crc = $this->crc_mbus($clean_answer);

        return $received_crc === $calculated_crc;
    }

    protected function prepare_command(string $str_command) : string 
    {
        return $str_command;
    }

    protected function parse_answer(string $data) 
    {
        return unpack('H*', $data, null)[1];
    }

    protected function make_request(string $message_command, bool $preparing = true, bool $parsing = true)
    {
        if ($preparing) {
            $command = $this->prepare_command($message_command);
        } else {
            $command = $message_command;
        }

        Log::info("Отправляем команду: ".$this->nice_hex($command));

        $device_connection = new Socket($this->connection_params);

        $binary_answer = $device_connection->get_answer($command);

        if (empty($binary_answer)) {
            Log::error("Отсутствует ответ от устройства.");

            return;
        } else if (!$this->crc_right($binary_answer)) {
            Log::error("Не совпадают контрольные суммы.");

            return;
        } else {
            if ($parsing) {
                $answer = $this->parse_answer($binary_answer);
            } else {
                $answer = $binary_answer;
            }
            
            Log::info("Получаем ответ: ".$this->nice_hex_string($answer));

            return $answer;
        }
    }

    public function write_to_db() : void {
        $this->device->consumptions()
            ->create($this->consumption_record);
    }
}