<?php

namespace App\Socket;

use Illuminate\Support\Facades\Log;

/**
 * Класс для создания сокет соединения,
 * отправки команд через соединение и
 * получения ответа
 */
class Socket {
    private $connection;
    private $errno;
    private $error_message;

    public function __construct($connection_params)
    {
        extract($connection_params);

        $this->connection = 
            stream_socket_client("$protocol://$ip:$port", $this->errno, $this->error_message, 3);
    }

    public function get_answer($command)
    {
        $result = false;

        if (!$this->connection) {
            Log::error("Ошибка соединения: $this->errno $this->error_message");
        } else {
            fwrite($this->connection, $command);

            $result = fread($this->connection, 8192);
        }
        
        fclose($this->connection);

        return $result;
    }
}