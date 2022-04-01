<?php
class Session
{
    private static $instance;

    public function login($user)
    {
        $_SESSION['is_logged_in'] = $user;
    }

    public function logout()
    {
        self::stopSession('is_logged_in');
        self::stopSession('Staff_Id');
        self::stopSession('Staff_Admin_Status');
        self::stopSession('Gym_Id');
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public  function getUser(){
        return $_SESSION['is_logged_in'] ?? false;
    }

    public static function startSession($k, $v)
    {
        session_start();
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