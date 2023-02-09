<?php
    class Regions{
        // підключення до бази даних і таблиці "regions"
        private $conn;
        private $table_name = "regions"; 
        public $region_id;

        // конструктор для підключення до бази даних 
        public function __construct($db, $config)
        {
            $this->conn = $db;
            $this->table_name =  $config['prefix'] ."_". $this->table_name;
        }

        public function read(){
            $query = "SELECT
                *
            FROM ".$this->table_name."
            ORDER BY
            name ASC
            ";
        
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
        }

        
        public function readOne($data){
            $query = "SELECT
                *
            FROM ".$this->table_name."
            WHERE 
                region_id = ?
            LIMIT 
                0,1
            ";
        
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['region_id']);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
        }
    }
?>