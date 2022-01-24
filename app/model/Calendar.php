<?php


class Calendar
{
    public static function checkCalendar()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                        Soccer_Id, 
                                        Soccer_Contact_Name,
                                        Soccer_Contact_Phone,
                                        YEAR(Soccer_Start_Time) AS SoccerYearStart, 
                                        YEAR(Soccer_End_Time) AS SoccerYearEnd, 
                                        MONTH(Soccer_Start_Time) AS SoccerMonthStart, 
                                        MONTH(Soccer_End_Time) AS SoccerMonthEnd, 
                                        DAY(Soccer_Start_Time) AS SoccerDayStart, 
                                        DAY(Soccer_End_Time) AS SoccerDayEnd,
                                        HOUR(Soccer_Start_Time) as SoccerHourStart,
                                        HOUR(Soccer_End_Time) as SoccerHourEnd

                                    FROM Soccer WHERE Soccer_Completed=:Soccer_Completed AND Soccer_Gym_Id=:Soccer_Gym_Id');
        $stmt->bindValue('Soccer_Completed', false);
        $stmt->bindValue('Soccer_Gym_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function checkCalendarDetails()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Soccer WHERE Soccer_Id=:Soccer_Id');
        $stmt->bindValue('Soccer_Id', Request::post('data'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function removeEvent()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('DELETE FROM Soccer WHERE Soccer_Id=:Soccer_Id');
        $stmt->bindValue('Soccer_Id', Request::post('Soccer_Id'));
        $stmt->execute();
    }
}