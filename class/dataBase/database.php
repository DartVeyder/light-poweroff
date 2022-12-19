<?php

class Database
{
    // укажите свои учетные данные базы данных
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    public $conn;
   

    // получаем соединение с БД
    public function getConnection($config)
    {
        $this->conn = null;
        $this->host = $config['host'];
        $this->db_name = $config['db_name'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->charset = $config['charset'];
        try {
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]; 
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name.";charset=". $this->charset, $this->username, $this->password, $opt);
            
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}