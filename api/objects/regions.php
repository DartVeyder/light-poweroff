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
                region_id, name
            FROM ".$this->table_name."
            ";
        
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
        }
    }
?>