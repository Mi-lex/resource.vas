<?php

namespace App\Drivers;

use App\Abstracts\Driver;
use Illuminate\Support\Facades\Log;

/**
 * Драйвер работает. Вопрос - зачем нужен параметр totalTimer?
 * в данной версии таймер имеет вид массива, что не может являться записью в базу данных
 */
class Oven_si9 extends Driver
{
    private $commands;

    private $consumptions;

    public function __construct($device)
    {
        parent::__construct($device);

        $this->connection_params['protocol'] = 'udp';

        /**
         * Протокол Овен бессмысленно усложнён, расчёт всех команд - боль,
         * поэтому приводятся все возможные команды для первых 15 адресов
         */
        $this->commands = [
            '1' => ['totalConsumption' => "GHHGSHNJQOHO", 'currentConsumption' => 'GHHGOVSITLVL', 'totalTimer' => 'GHHGUMPSPISM'],
            '2' => ['totalConsumption' => "GIHGSHNJUNHQ", 'currentConsumption' => 'GIHGOVSIPQVN', 'totalTimer' => 'GIHGUMPSTTSK'],
            '3' => ['totalConsumption' => "GJHGSHNJTTUK", 'currentConsumption' => 'GJHGOVSIQGGP', 'totalTimer' => 'GJHGUMPSUNJQ'],
            '4' => ['totalConsumption' => "GKHGSHNJNPHU", 'currentConsumption' => 'GKHGOVSIGKVJ', 'totalTimer' => 'GKHGUMPSKJSG'],
            '5' => ['totalConsumption' => "GLHGSHNJKJUG", 'currentConsumption' => 'GLHGOVSIJUGT', 'totalTimer' => 'GLHGUMPSNPJU'],
            '6' => ['totalConsumption' => "GMHGSHNJGSUI", 'currentConsumption' => 'GMHGOVSINHGV', 'totalTimer' => 'GMHGUMPSJMJS'],
            '7' => ['totalConsumption' => "GNHGSHNJJMHS", 'currentConsumption' => 'GNHGOVSIKRVH', 'totalTimer' => 'GNHGUMPSGSSI'],
            '8' => ['totalConsumption' => "GOHGSHNJSQKH", 'currentConsumption' => 'GOHGOVSIRNQS', 'totalTimer' => 'GOHGUMPSVGPV'],
            '9' => ['totalConsumption' => "GPHGSHNJVGRV", 'currentConsumption' => 'GPHGOVSIOTLI', 'totalTimer' => 'GPHGUMPSSQMH'],
            '10' => ['totalConsumption' => "GQHGSHNJRVRT", 'currentConsumption' => 'GQHGOVSISILG', 'totalTimer' => 'GQHGUMPSOLMJ'],
            '11' => ['totalConsumption' => "GRHGSHNJOLKJ", 'currentConsumption' => 'GRHGOVSIVOQU', 'totalTimer' => 'GRHGUMPSRVPT'],
            '12' => ['totalConsumption' => "GSHGSHNJIHRP", 'currentConsumption' => 'GSHGOVSILSLK', 'totalTimer' => 'GSHGUMPSHRMN'],
            '13' => ['totalConsumption' => "GTHGSHNJHRKN", 'currentConsumption' => 'GTHGOVSIMMQQ', 'totalTimer' => 'GTHGUMPSIHPP'],
            '14' => ['totalConsumption' => "GUHGSHNJLKKL", 'currentConsumption' => 'GUHGOVSIIPQO', 'totalTimer' => 'GUHGUMPSMUPR'],
            '15' => ['totalConsumption' => "GVHGSHNJMURR", 'currentConsumption' => 'GVHGOVSIGJLM', 'totalTimer' => 'GVHGUMPSLKML']
        ];

        $this->consumptions = ['totalConsumption', 'currentConsumption'];
    }

    protected function get_clean_answer(string $answer): string
    {
        return substr($answer, 2, -4);
    }

    /**
     * Переопределяю метод проверки контрльной суммы,
     * потому что хуй знает, как протокол oven_si9 работает
     */
    protected function crc_right(string $answer = ''): bool
    {
        return true;
    }

    protected function prepare_command(string $consumption_type): string
    {
        $rs_port_hex = $this->device->rs_port;

        return '#' . $this->commands[$rs_port_hex][$consumption_type] ."\r";
    }

    // переводит двоично-десятичное число из протокола Овен в нормальный вид
    private function extract_int(string $ascii_str)
    {
        $result = 0;
        
        for ($pos = 1; $pos <= strlen($ascii_str); $pos++) {
            $digit = ord(substr($ascii_str, 0 - $pos, 1)) - 71;
            $result += $digit * pow(10, $pos - 1);
        }

        return $result;
    }

    // Извлекает время наработки
    private function parse_timer(string $ascii_str) : array
    {
        $time = array();
        $time["miliseconds"] = $this->extract_int(substr($ascii_str, 19, 2));
        $time["seconds"] = $this->extract_int(substr($ascii_str, 17, 2));
        $time["minutes"] = $this->extract_int(substr($ascii_str, 15, 2));
        $time["hours"] = $this->extract_int(substr($ascii_str, 9, 6));

        return $time;
    }

    // Извлекает число из псведо-float значения
    protected function parse_data(string $ascii_string) : int
    {
        $exponent_ascii = substr($ascii_string, 9, 1);

        // полагаем, что числа всегда положительные, бит знака игнорируем
        $exponent = $this->extract_int($exponent_ascii);

        $mantissa_ascii = substr($ascii_string, 10, 7);

        $mantissa = $this->extract_int($mantissa_ascii);

        return $mantissa * pow(10, 0 - $exponent);
    }

    private function write_data(string $consumption,
        callable $parser) : void
    {
        $answer = $this->make_request($consumption, false);

        if ($answer) {
            $this->consumption_record[$consumption] = $parser($answer);

            Log::info("Успешно получены показания: $consumption");
        } else {
            Log::error("Получение $consumption не выполнено");
        }
    }

    public function collect_data() : void
    {
        // Записываем общее потребление и нынешнее потребленее
        foreach ($this->consumptions as $consumption) {
            $this->write_data($consumption, [$this, 'parse_data']);
        }

        // Запсываем показание времени наработки (??)
        $this->write_data('totalTimer', [$this, 'parse_timer']);

        dd($this->consumption_record);
    }
}
