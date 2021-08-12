<?php


class DashboardController extends SecurityController
{
    public function Dashboard()
    {
        $this->employeeCheck();
        Membership::timeUpdate();

        $view=New View();
        $view->render('Dashboard/index',
            [
                'staffName'             => Session::getInstance()->getUser()->Staff_Username,
                'gymData'               => Dashboard::gymData(),
                'gymDataCount'          => Dashboard::gymDataCount(),
                'gymName'               => Dashboard::gymName(),
                #'userData'             => User::allUsers(),
                'allUsersCount'         => User::allUsersCount(),
                'activeUsersCount'      => User::allActiveUsersCount(),
                'inactiveUsersCount'    => User::allInactiveUsersCount(),
                'newMonthlyUsers'       => User::currentMonthlyUsers(),
                'monthlyUserProportion' => User::monthlyUserProportion(),
                'monthlyIncome'         => Statistics::monthlyIncome()
            ]);

    }

    public function dashboardCheck(){
        if (Session::getInstance()->getUser()->Staff_Adminstatus==4){
            header( 'Location:'.App::config('url').'Dashboard/Dashboard');
        } elseif(Session::getInstance()->getUser()->Staff_Adminstatus==3){
            header( 'Location:'.App::config('url').'Dashboard/Staff_Dashboard');
        }else{
            header( 'Location:'.App::config('url'));
        }
    }
}