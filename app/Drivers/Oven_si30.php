<?php

namespace App\Drivers;

use App\Abstracts\Driver;
use Illuminate\Support\Facades\Log;
use ModbusTcpClient\Network\BinaryStreamConnection;
use ModbusTcpClient\Packet\ModbusFunction\ReadInputRegistersRequest;
use ModbusTcpClient\Packet\ModbusFunction\ReadInputRegistersResponse;
use ModbusTcpClient\Packet\ResponseFactory;
use App\Socket\Socket;

/**
 * Драйвер работает. Вопрос - зачем нужен параметр totalTimer?
 * в данной версии таймер имеет вид массива, что не может являться записью в базу данных
 */
class Oven_si30 extends Driver
{
    private $consumptions;

    private $HARDCODED_IP = '192.168.1.2';
    private $HARDCODED_PORT = '40000';

    public function __construct($device)
    {
        parent::__construct($device);

        $this->connection_params['protocol'] = 'tcp';

        $this->consumptions = ['consumption_amount', 'current_consumption'];
    }

    private function consumption_cmd()
    {
        // адрес регистра 
        /**
         * $startAddress - Адрес регистра текущего значения счетчика (counter value) - 0x0000, 0x0001
         * $quantity - количество слов (word - 2 байта), которые нужно прочесть
         */
        $startAddress = 0;
        $quantity = 2;

        $packet = new ReadInputRegistersRequest($startAddress, $quantity);

        return $packet;
    }

    protected function make_own_request($packet_cmd)
    {
        $connection = BinaryStreamConnection::getBuilder()
            ->setTimeoutSec(10.0)
            ->setConnectTimeoutSec(10.0)
            ->setReadTimeoutSec(10.0)
            ->setPort($this->HARDCODED_PORT)
            ->setHost($this->HARDCODED_IP)
            ->build();

        try {
            $binaryData = $connection->connect()
                ->sendAndReceive($packet_cmd);

            Log::info('Binary received (in hex):   ' . unpack('H*', $binaryData)[1]);
            /**
             * @var $response ReadHoldingRegistersResponse
             */
            $response = ResponseFactory::parseResponseOrThrow($binaryData);
            // Log::info('Parsed packet (in hex):     ' . 1$2response->3t4oHex());
            // Log::info('Data parsed from packet (bytes):');

            Log::info(print_r($response->getData()));

            Log::info('Response as word');
            foreach ($response as $word) {
                Log::info(print_r($word->getBytes()));
            }

            Log::info('Response as double words');
            foreach ($response->asDoubleWords() as $doubleWord) {
                $doubleTrouble = $doubleWord->getBytes();

                Log::info('Int: ');
                Log::info(print_r($doubleTrouble->getInt32()));

                Log::info('UInt: ');
                Log::info(print_r($doubleTrouble->getUInt32()));

                Log::info('Float: ');
                Log::info(print_r($doubleTrouble->getFloat()));
            }
        } catch (Exception $exception) {
            Log::error('An exception occurred: ' . $exception->getMessage());
            Log::error('Trace: ' . $exception->getTraceAsString());
        } finally {
            $connection->close();
        }
    }

    public function collect_data()
    {
        $packet = $this->consumption_cmd();

        $this->make_own_request($packet);
    }

    public function test_connection()
    {
        $device_connection = new Socket($this->connection_params);

        $command = null;

        $binary_answer = $device_connection->get_answer($command);

        if (empty($binary_answer)) {
            Log::error("Отсутствует ответ от устройства.");

            return;
        } else {
            $answer = $binary_answer;

            Log::info("Получаем ответ: " . $this->nice_hex($answer));

            return $answer;
        }
    }
}
