<?php
    class Weekday{
        // підключення до бази даних і таблиці "regions"
        private $conn;
        private $table_name = "weekdays";

        public $region_id;

        // конструктор для підключення до бази даних 
        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read(){
            $query = "SELECT
                weekday_id, name
            FROM ".$this->table_name."
            ";
        
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
        }

        public function readOne($data){
            

            $query = "SELECT
                weekday_id, name
            FROM 
                ".$this->table_name."
            WHERE 
                weekday_id = ?
            LIMIT 
                0,1
            ";
        
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['weekday_id']);
        
        // выполняем запрос
        $stmt->execute();
        return $stmt;
        }
    }
?>