<?php
class Controller_group extends Controller
{
    public static $params;
    public static function index($array, $id, $action)
    {
        $group = Model_group::index($id);
        $group['action'] = $action;
        
        View_group::index($array,  $group);
    }
}
