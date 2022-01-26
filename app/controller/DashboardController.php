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
                'activeUsersCount'      => User::allActiveUsersCount()->activeUsersCount,
                'newMonthlyUsers'       => User::currentMonthlyUsers()->newMonthlyUsers,
                'monthlyUserProportion' => User::monthlyUserProportion(),
                'yearlyStats'           => Statistics::yearlyStats(),
                'monthsInYear'          => Statistics::monthsInYear(),
                'monthlyIncome'         => Statistics::monthlyIncome()->Users_Memberships_Price_Month,
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