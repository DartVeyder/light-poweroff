<?php
    class Weekday{
        // підключення до бази даних і таблиці "regions"
        private $conn;
        private $table_name = "weekdays";
        private $table_prefix;

        public $region_id;

        // конструктор для підключення до бази даних 
        public function __construct($db, $config)
        {
            $this->conn = $db;
            $this->table_prefix = $config['prefix'] . "_";
            $this->table_name = $this->table_prefix . $this->table_name;
        }

        public function read(){
            $query = "SELECT
                weekday_id, name, short_name
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
                weekday_id, name, short_name
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