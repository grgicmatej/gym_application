<?php


class LoginController extends SecurityController
{
    public function login()
    {
        if (Staff::loginCheck()){
            if (Staff::passwordCheck()){
                Admin::logedUserStart();
                Dashboard::changeGym();
                //missing sending email part if current or past day <= today
                header( 'Location:'.App::config('url').'Dashboard/dashboardCheck');
            }else{
                echo json_encode(false);
            }
        }else{
            echo json_encode(false);
         }
    }

    public function logout()
    {
        Admin::endStaffActivity();
        Admin::staffLogOut();
        header( 'Location:'.App::config('url'));
    }
}