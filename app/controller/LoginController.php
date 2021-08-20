<?php


class LoginController extends SecurityController
{
    public function login()
    {

        if (Staff::loginCheck()){
            if (Staff::passwordCheck()){
                Admin::logedUserStart();
                Session::startSession('Staff_Id', Session::getInstance()->getUser()->Staff_Id);
                Session::startSession('Staff_Logged_In', 1);
                Session::startSession('Staff_Admin_Status', Session::getInstance()->getUser()->Staff_Adminstatus);

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