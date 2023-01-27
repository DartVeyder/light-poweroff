<?php 
class Controller_back{
    public static function index($result){
        
        Callback::route($result, 1); 
    }
}