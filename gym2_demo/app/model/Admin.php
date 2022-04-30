<?php


class Admin
{
    public static function checkStaffActivity()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Activity_Staff WHERE Activity_Staff_Staff_Id=:activityStaffStaffId ORDER BY Activity_Staff_Staff_Id DESC LIMIT 1');
        $stmt->bindValue('activityStaffStaffId', 1);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function endStaffActivity()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Activity_Staff SET
                                Activity_Staff_End_Time=NOW()
                                WHERE
                                Activity_Staff_Id=:activityStaffId
                              ');
        $stmt->bindValue('activityStaffId', 1);
        $stmt->execute();
    }
    
    public static function logedUserStart()
    {
        $_SESSION['Staff_Id'] = 1;
        $_SESSION['Staff_Logged_In'] = 1;
        $_SESSION['Staff_Admin_Status'] = 4;

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
        $stmt->bindValue('Activity_Staff_Staff_Id', 1);
        $stmt->execute();
    }

    public static function staffLogOut()
    {
        Session::getInstance()->logout();
    }
}