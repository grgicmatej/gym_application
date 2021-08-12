<?php


class Admin
{
    public static function logedUserStart()
    {
        $_SESSION["Staff_Id"] = Session::getInstance()->getUser()->Staff_Id;
        $_SESSION["Staff_Logged_In"] = 1;
        $_SESSION["Staff_Admin_Status"] = Session::getInstance()->getUser()->Staff_Adminstatus;

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