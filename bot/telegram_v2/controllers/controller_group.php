<?php
class Controller_group extends Controller
{
    public static $params;
    public static function index($array, $id)
    {
        $group = Model_group::index($id);

        View_group::index($array,  $group);
    }
}
