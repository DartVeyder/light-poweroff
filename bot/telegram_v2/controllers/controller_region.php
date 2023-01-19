<?php
class Controller_region extends Controller
{
    public static $params;


    public static function index($array)
    {
        $region = Model_region::index($array);
        View_region::index($array, $region);
    }
}
