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
    private $max_bytes_length;

    public function __construct($connection_params)
    {
        extract($connection_params);

        $this->connection = 
            stream_socket_client("$protocol://$ip:$port", $this->errno, $this->error_message, 3);

        $this->max_bytes_length = 8192;
    }

    /**
     * Открывает сокет соединение с устройством
     * отправляет команды и получает ответ
     *
     * @param string $command - команда в виде 
     * шестнадцатеричного кода упакованного в 
     * бпнарную строку
     * @return void|string - ответ в виде
     * бинарной строки
     */
    public function get_answer(string $command)
    {
        $result = false;

        if (!$this->connection) {
            Log::error("Ошибка соединения: $this->errno $this->error_message");
        } else {
            fwrite($this->connection, $command);

            $result = fread($this->connection, $this->max_bytes_length);
        }
        
        fclose($this->connection);

        return $result;
    }
}