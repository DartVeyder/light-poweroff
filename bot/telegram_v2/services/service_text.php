<?php
    class Service_text{

        public static function get_message_text($data = [] ){
            extract($data);
            $array = [
                "start" => "Привіт, ".$first_name." ! Цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область.",
                "title_create_group" => "Тепер виберіть вашу групу.",
                "text_region_none_active" => "На жаль, графік по вашій області, поки, не доступний☹️ Не засмучуйтесь, бот постійно оновлюється і ми надішлемо вам сповіщення, як тільки графік по вашій області буде доступним)\n\n",
                "text_region_free" => "Подивитись актуальний графік аварійних та планових відключень можна на сайті або у фейсбуці за посиланням нижче",
                "text_title_shedule_shutdown" => "====== ГРАФІК ВІДКЛЮЧЕНЬ ======",
                "text_title_today" => 'Сьогодні:',
                "text_title_checked" => 'Вибрано:',
                "text_title_your_group" => 'Ваша група:',
                "button_back_text" => "<< Назад",
                "button_group_text" => "Група",
                "button_oficial_site" => "Оф. сайт",
                "button_facebook" => "Фейсбук",
                "button_setting" => "Налаштування",
                "button_donate" => "Донат",
                "button_developer" => "Розробник",
                "button_shutdown_shedule" => "Графік відключень",
                "button_edit_notification" => "Сповіщення",
                "button_edit_region" => "Змінити область",
                "button_edit_group" => "Змінити групу",
                "setting_title_text" => "<b>Група:</b> $group_id\n <b>Область:</b> $region_name\n ",
                "setting_title_text_notification" => "<b>Сповіщення: </b>",
                "setting_title_text_nottification_on" => "Включено ✅",
                "setting_title_text_nottification_off" => "Виключено ❌",
                "text_title_edit_group" => "<b>====== ЗМІНИТИ ГРУПУ ======</b>\n Виберіть групу"
            ];
            return  $array;
        } 
    }
    