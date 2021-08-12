<?php
class Session
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }

    public function login($user)
    {
        $_SESSION['is_logged_in'] = $user;
    }

    public function logout()
    {
        unset($_SESSION['is_logged_in']);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) ? true : false;
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public  function getUser(){
        return isset($_SESSION['is_logged_in']) ? $_SESSION['is_logged_in'] : false;
    }

    public static function startSession($k, $v)
    {
        if(isset($_SESSION[$k])){
            unset($_SESSION[$k]);
        }
        $_SESSION[$k]=$v;
    }

    public static function stopSession($k)
    {
        if(isset($_SESSION[$k])){
            unset($_SESSION[$k]);
        }
    }
}