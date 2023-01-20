<?php
class Controller_region extends Controller
{
    public static $params;


    public static function index($array, $action)
    {
        $region = Model_region::index($array);
        $region['action'] = $action;
        View_region::index($array, $region,
    );
    }
}
