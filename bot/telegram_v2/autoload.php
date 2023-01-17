use Exception;
    <?php
    class ClassLoader{ 
        public static $dir = [
            'system',
            'controllers',
            'models',
            'views',
            'services'
        ];
    
        public static function autoload($className){
            self::library($className);
           
            //Проверка был ли объявлен класс
            if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
                throw new Exception('Невозможно найти класс '.$className);
            }  
        }

        public static function library($className){
            
            foreach (self::$dir as $d){
                
                $filename = mb_strtolower( ROOT_DIR.'/'. $d . '/'. $className . ".php");
                  
                if (is_readable($filename)) {
                    require_once $filename; 
                  
                }

               
            }   
            
        }
}