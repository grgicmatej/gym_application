<?php


class SecurityController
{
    public function Employee_Check()
    {
        if (!isset($_COOKIE['Staff_Admin_Status'])){
            //header( 'Location:'.App::config('url').'Login/Login/');
        }else{
            if ($_COOKIE['Staff_Admin_Status']==3){
                //header( 'Location:'.App::config('url').'Dashboard/Staff_Dashboard/');
            }
        }
    }
}