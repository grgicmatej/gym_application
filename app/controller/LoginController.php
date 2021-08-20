<?php


class LoginController extends SecurityController
{
    public function login()
    {

        if (Staff::loginCheck()){
            if (Staff::passwordCheck()){
                Admin::logedUserStart();
                Dashboard::changeGym();
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
        Session::getInstance()->logout();
        $view=New View();
        $view->render('index');
    }
}