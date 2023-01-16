<?php 

class Application {
    
    public function run(){
            $this->Loader();
            
    }
    
    public function Loader(){
        spl_autoload_register(['ClassLoader', 'autoload'], true, false);

        try{
            $result = Core::getTelegramResult();
            if (isset($result['callback_query'])){
                    
            }else{
                new Message($result);
            }
            
            
            
            echo Controller_start::$params; //KSL  

        } catch (Exception $e){
            echo '<h2>Внимание! Обнаружена ошибка.</h2>'.
            '<h4>'.$e->getMessage().'</h4>'.
           '<pre>'.$e->getTraceAsString().'</pre>';
            exit;
        }
    }
    
}