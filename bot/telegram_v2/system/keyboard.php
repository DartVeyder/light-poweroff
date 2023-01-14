<?php
    class Keyboard{
        private static $col;
        private static $row;
        private static $callback_prefix;
        private static $array;


        public static function reply_markup($col = [], $row = [], $callback_prefix = '', $array, $merge = [], $type_keyboard){
            self::$col = $col;
            self::$row = $row;
            self::$callback_prefix = $callback_prefix;
            self::$array = $array;
  
            $get_array_buttons = self::get_array_buttons($type_keyboard);

            if($merge){
                $get_array_buttons = array_merge($get_array_buttons, $merge);
            }
            
            $reply_markup = self::type_menu($type_keyboard, $get_array_buttons);
            return $reply_markup;
            
        }

        //Вибір Типу меню 
        private static function type_menu($type_keyboard, $menu){
            $array = [
                'resize_keyboard' => true,
                $type_keyboard => $menu
            ];

            if($type_keyboard == "keyboard"){
                $array['one_time_keyboard'] = false;
            } 
 
            $telegram = Core::getTelegram();

            return  $telegram->replyKeyboardMarkup($array);
        }

        //Формування масива кнопок 
        private static function get_array_buttons($type_keyboard)
        {
            if($type_keyboard == "keyboard"){
                $data = [['button']];

            } else {
                if (empty(self::$row) && count(self::$col) == 1) {
                    foreach (self::$array as $key => $item) {
                        $row[] = ['text' => $item['name'], 'callback_data' => self::$callback_prefix . '_' . $item['id']];
                    }

                    $data = array_chunk($row, self::$col[0]);
                } else {
                    $data = [[['text' => 'Помилка', 'callback_data' => 'error']]];
                }
            }

            return $data;
        }

        
    }
?>