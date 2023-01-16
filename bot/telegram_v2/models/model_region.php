<?php
    class Model_region
    {
        public static function index()
        {
            $data = Core::cUrl("/regions/read.php");  
            $menu = [];
            foreach ($data['records'] as $item)
            {
                $menu[] = [
                    'name' => $item['region_name'],
                    'id' => $item['region_id']
                ];
            }

            return  $menu;
        } 
    }