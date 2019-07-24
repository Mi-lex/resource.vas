<?php

namespace App\Abstracts;

use App\Socket\Socket;
use Illuminate\Support\Facades\Log;

abstract class Driver
{
    // прибор учета
    protected $device;
    // параметры соединения с устройством
    protected $connection_params;
    // запись о потреблении устройства
    protected $consumption_record;

    public function __construct($device)
    {
        $this->device = $device;

        $this->connection_params['ip'] = $device->server_ip;
        $this->connection_params['protocol'] = $device->converter->protocol;
    }

    /**
     * Принимает двоичные HEX данные и 
     * возвращает строку для отображения
     *
     * @param string $str - запакованные hex данные
     * @return string распакованный hex
     */
    protected function nice_hex(string $str): string
    {
        // Проверить правильность работы с двумя аргументами
        $unpacked_str = unpack('H*', $str, null)[1];

        return $this->nice_hex_string($unpacked_str);
    }

    /**
     * Разбивает полученный hex по два элемента
     *
     * @param string $str - hex строка
     * @return string - разбитая hex строка
     */
    protected function nice_hex_string(string $str): string
    {
        return strtoupper(implode(' ', str_split($str, 2)));
    }

    /**
     * Принимает данные и возвращает CRC16 стандарта XMODEM в виде HEX строки
     * Данный метод позволяет определить, совпадают ли контрольные суммы пакетов
     * протокол у устройств разный, поэтому метод для каждого устройства индивидуален
     *
     * @param string $msg - принятый ответ
     * @return string - высчитанная контрольная сумма
     * в двоичном виде
     */
    protected function crc_mbus(string $msg): string
    {
        return $msg;
    }

    // Функция извлечения контрольной суммы из строки ответа
    protected function get_clean_answer(string $answer): string
    {
        return $answer;
    }

    /**
     * Определяет совпадение контрольной суммы
     * полученного пакета
     *
     * @param string $answer - полученный ответ, запакованная строка
     * @return boolean
     */
    protected function crc_right(string $answer = ''): bool
    {
        $unpacked_answer = unpack('H*', $answer, null)[1];

        $received_crc = strtoupper(substr($unpacked_answer, -4));

        // Необходимо обработать строку для каждого счетчика по-своему
        $clean_answer = $this->get_clean_answer($unpacked_answer);
        $calculated_crc = $this->crc_mbus($clean_answer);

        return $received_crc === $calculated_crc;
    }

    /**
     * Фукнция обработки команды перед отправкой
     * в устройство
     *
     * @param string $str_command - команда
     * @return string обработанная команда
     */
    protected function prepare_command(string $str_command): string
    {
        return $str_command;
    }

    protected function parse_answer(string $data)
    {
        return unpack('H*', $data, null)[1];
    }

    /**
     * Метод запроса к устройству
     *
     * @param string $message_command - отправляемая команда
     * @param boolean $preparing - нужно ли обрабатывать перед
     * отправкой в устройство [optional]
     * @param boolean $parsing - нужно ли парсить полученный ответ
     * [optional]
     * @return void|string - ответ устройства (вид зависит от парсинга)
     */
    protected function make_request(string $message_command, bool $preparing = true, bool $parsing = true)
    {
        if ($preparing) {
            $command = $this->prepare_command($message_command);
        } else {
            $command = $message_command;
        }

        Log::info("Отправляем команду: " . $this->nice_hex($command));
        Log::info("Отправляем команду (hex): " . $this->nice_hex_string($command));

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

                Log::info("Получаем ответ: " . $this->nice_hex_string($answer));
            } else {
                $answer = $binary_answer;

                Log::info("Получаем ответ: " . $this->nice_hex($answer));
            }

            return $answer;
        }
    }

    /**
     * Записывает данные о потреблении устройства
     * в базу данных
     *
     * @return void
     */
    public function write_to_db(): void
    {
        $this->device->consumptions()
            ->create($this->consumption_record);
    }
}
