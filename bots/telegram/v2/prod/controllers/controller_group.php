<?php
class Controller_group extends Controller
{
    public static $params;
    public static function index($result_telegram, $group_id, $action)
    {
        $group = Model_group::index($group_id, $result_telegram['user_id']);
        $group['action'] = $action;

        View_group::index($result_telegram,  $group);
    }

    public static function edit($result_telegram, $action)
    {
        $group =  Model_group::edit($result_telegram);
        $group['action'] = $action;

        View_group::edit($result_telegram,  $group);
    }

    public static function update($result_telegram, $group_id, $action)
    {
        $group =  Model_group::edit($result_telegram, $group_id);
        $group['action'] = $action;
        Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'group_id' => $group_id]);
        View_group::edit($result_telegram,  $group);
    }
}
 