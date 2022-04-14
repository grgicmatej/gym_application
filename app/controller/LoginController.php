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
                $view=New View();
                $view->render('index',['message'=>'E-mail ili lozinka ne odgovaraju nijednom korisniku']);
            }
        }else{
            $view=New View();
            $view->render('index',['message'=>'E-mail ili lozinka ne odgovaraju nijednom korisniku']);
        }
    }

    public function logout()
    {
        Admin::endStaffActivity();
        Admin::staffLogOut();
        $view=New View();
        $view->render('index');
    }
}