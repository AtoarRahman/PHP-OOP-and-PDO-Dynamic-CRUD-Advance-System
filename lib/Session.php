<?php
class Session{
    public static function init(){
        if(version_compare(phpversion(), '5.4.0', '<')){
            if(session_id() == ''){
                session_start();
            }
        }else{
            if(session_status() == PHP_SESSION_NONE){
                session_start();
            }
        }
    }
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }
    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }
}