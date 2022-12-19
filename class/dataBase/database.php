<?php

class Database
{
    // укажите свои учетные данные базы данных
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;
   

    // получаем соединение с БД
    public function getConnection($config)
    {
        $this->conn = null;
        $this->host = $config['host'];
        $this->db_name = $config['db_name'];
        $this->username = $config['username'];
        $this->password = $config['password'];

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}