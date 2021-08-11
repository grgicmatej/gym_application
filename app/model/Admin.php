<?php


class Admin
{
    public static function logedUserStart()
    {
        $staffId=Session::getInstance()->getUser()->Staff_Id;
        $staffLoggedIn=1;
        $staffAdminStatus=Session::getInstance()->getUser()->Staff_Adminstatus;

        $cookieName="Staff_Id";
        $cookieValue=$staffId;
        setcookie($cookieName, $cookieValue, time() + (43200), "/");

        $cookieName="Staff_Logged_In";
        $cookieValue=$staffLoggedIn;
        setcookie($cookieName, $cookieValue, time() + (43200), "/");

        $cookieName="Staff_Admin_Status";
        $cookieValue=$staffAdminStatus;
        setcookie($cookieName, $cookieValue, time() + (43200), "/");

        $time=time()+7200;
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO 
                                Activity_Staff 
                                (
                                Activity_Staff_Staff_Id,
                                Activity_Staff_Start_Time
                                )
                                VALUES
                                (
                                :Activity_Staff_Staff_Id,
                                :Activity_Staff_Start_Time
                                )      
                              ');
        $stmt->bindValue('Activity_Staff_Staff_Id', $staffId);
        $stmt->bindValue('Activity_Staff_Start_Time', $time);
        $stmt->execute();
    }
}