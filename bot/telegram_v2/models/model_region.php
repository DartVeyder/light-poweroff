<?php
class Model_region
{
    public static function index()
    {
        $data = Core::get("/regions/read.php");

        $menu = [];
        foreach ($data['records'] as $item) {
            $menu[] = [
                'text' => $item['region_name'],
                'callback_data' => "region_" . $item['region_id']
            ];
        }

        return  $menu;
    }
}
