<?php
    class Model_notification extends Model{
        public static function edit($result_telegram, $notification_id = ''){
            $user        = Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
            $lang_text   = Service_text::get_message_text($user);
            $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_setting');
           
            $notification_id = ($notification_id == '') ?  $user['notification'] : $notification_id;
           
            $buttons_notification = Button_notification::list($notification_id, $lang_text);
            $text = $lang_text['text_title_edit_notification'];
            
            return self::message($text, $buttons_notification, $button_back);;
        }
    }