<?php
class Controller_start extends Controller
{
    public static $params;


    public static function index($array)
    {
        $region = Model_region::index($array);

        View_start::index($array, $region);
    }
}
