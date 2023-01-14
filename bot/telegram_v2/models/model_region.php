<?php
    class Model_region
    {
        public static function index()
        {
            $data = Core::cUrl("/regions/read.php");  
            return self::get_menu($data['records']); 
        }

        private static function get_menu($data){
            $menu = [];
            foreach ($data as $item)
            {
                $menu[] = [
                    'name' => $item['region_name'],
                    'id' => $item['region_id']
                ];
            }
            return $menu;
        }
    }