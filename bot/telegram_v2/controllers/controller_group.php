<?php
class Controller_group extends Controller
{
    public static $params;
    public static function index($result_telegram, $id, $action)
    {
        $group = Model_group::index($id);
        $group['action'] = $action;
        
        View_group::index($result_telegram,  $group);
    }

    public static function edit($result_telegram, $action){
       $group =  Model_group::edit($result_telegram);
       $group['action'] = $action;
       
       View_group::edit($result_telegram,  $group);

    }

    public static function update($result_telegram, $group_id, $action){
        $setting = Model_setting::index($result_telegram);
        $setting['action'] = $action;   
        View_setting::index($result_telegram, $setting);
 
     }
}
