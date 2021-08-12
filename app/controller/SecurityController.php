<?php


class SecurityController
{
    public function employeeCheck()
    {
        if (!Session::getInstance()->getUser()->Staff_Adminstatus){
            header( 'Location:'.App::config('url'));
        }else{
            if (Session::getInstance()->getUser()->Staff_Adminstatus != 4){
                header( 'Location:'.App::config('url').'Dashboard/Staff_Dashboard/');
            }
        }
    }
}