<?php
class Controller_region extends Controller
{
    public static function index($result_telegram, $action)
    {
        $region = Model_region::index($result_telegram);
        $region['action'] = $action;
        View_region::index($result_telegram, $region);
    }

    public static function edit($result_telegram, $action)
    {
        $region = Model_region::edit($result_telegram);
        $region['action'] = $action;
        View_region::index($result_telegram, $region);
    }

    public static function update($result_telegram, $region_id, $action){
        $region = Model_region::edit($result_telegram, $region_id);
        $region['action'] = $action;
        Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'region_id' => $region_id]);
        View_region::index($result_telegram, $region);
    }

}
