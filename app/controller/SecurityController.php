<?php


class SecurityController
{
    public function employeeCheck()
    {
        if (!isset($_COOKIE['Staff_Admin_Status']) OR !Session::getInstance()->getUser()->Staff_Adminstatus){
            header( 'Location:'.App::config('url'));
        }else{
            if (Session::getInstance()->getUser()->Staff_Adminstatus == 3){
                header( 'Location:'.App::config('url').'Dashboard/Staff_Dashboard/');
            }
        }
    }
}