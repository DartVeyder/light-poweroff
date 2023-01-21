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
        $setting = Model_setting::index($result_telegram);
        $setting['action'] = $action;   
        View_setting::index($result_telegram, $setting);
    }

}
