<?php
class Controller_start extends Controller
{
    public static $params;


    public static function index($array, $action)
    {
        $region = Model_region::index($array);
        $region['action'] = $action;
        View_start::index($array, $region);
    }
}
