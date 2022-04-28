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
                //$view=New View();
                //$view->render('Public/index',['message'=>'E-mail ili lozinka ne odgovaraju nijednom korisniku']);

            }
        }else{
            echo json_encode(false);
           // $view=New View();
            //$view->render('Pndex',['message'=>'E-mail ili lozinka ne odgovaraju nijednom korisniku']);
            //echo json_encode(false);
        }
    }

    public function logout()
    {
        Admin::endStaffActivity();
        Admin::staffLogOut();
        $view=New View();
        header( 'Location:'.App::config('url'));

    }
}