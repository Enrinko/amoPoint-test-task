<?php

namespace src\php;
use Exception;
use mysqli;

class Connection
{
    private $serverName;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->serverName = 'localhost'; // Замените на ваш сервер
        $this->username = 'your_u'; // Замените на ваше имя пользователя
        $this->password = 'your_p'; // Замените на ваш пароль
        $this->dbname = 'your_db'; // Имя вашей базы данных
        $conn = $this->connect();
        $conn->close();
    }

    private function connect() {
        // Создаем соединение
        $conn = new mysqli($this->serverName, $this->username, $this->password, $this->dbname);

// Проверяем соединение
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    private function query($conn, $sql)
    {
        $res = $conn->query($sql);
        if ($res) {
            return $res;
        } else {
            throw new Exception("Error inserting data: " . $conn->error);
        }

    }

    public function create($data) {
        $conn = $this->connect();
        $ip = $conn->real_escape_string($data['ip']);
        $city = $conn->real_escape_string($data['city']);
        $device = $conn->real_escape_string($data['device']);
        // Вставляем данные в таблицу
        $sql = "INSERT INTO visits (ip, city, device) VALUES ('$ip', '$city', '$device')";
        $this->query($conn, $sql);
        $conn->close();
    }
    public function get($sql)
    {
        $conn = $this->connect();
        $res = $this->query($conn, $sql);
        $conn->close();
        return $res;
    }
}
