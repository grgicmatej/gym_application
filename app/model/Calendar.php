<?php


class Calendar
{
    public static function checkCalendar()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Soccer WHERE Soccer_Completed=:Soccer_Completed AND Soccer_Gym_Id=:Soccer_Gym_Id');
        $stmt->bindValue('Soccer_Completed', false);
        $stmt->bindValue('Soccer_Gym_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0));
        $stmt->execute();
        return $stmt->fetchAll();
    }
}