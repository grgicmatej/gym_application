<?php


class Admin
{
    public static function logedUserStart()
    {
        $_SESSION["Staff_Id"] = Session::getInstance()->getUser()->Staff_Id;
        $_SESSION["Staff_Logged_In"] = 1;
        $_SESSION["Staff_Admin_Status"] = Session::getInstance()->getUser()->Staff_Adminstatus;

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
                                NOW()
                                )      
                              ');
        $stmt->bindValue('Activity_Staff_Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }
}