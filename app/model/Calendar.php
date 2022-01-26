<?php


class Calendar
{
    public static function checkCalendar()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                        Event_Id, 
                                        Event_Contact_Name,
                                        Event_Contact_Phone,
                                        YEAR(Event_Start_Time) AS EventYearStart, 
                                        YEAR(Event_End_Time) AS EventYearEnd, 
                                        MONTH(Event_Start_Time) AS EventMonthStart, 
                                        MONTH(Event_End_Time) AS EventMonthEnd, 
                                        DAY(Event_Start_Time) AS EventDayStart, 
                                        DAY(Event_End_Time) AS EventDayEnd,
                                        HOUR(Event_Start_Time) as EventHourStart,
                                        HOUR(Event_End_Time) as EventHourEnd

                                    FROM Events WHERE Event_Completed=:Event_Completed AND Event_Gym_Id=:Event_Gym_Id AND Event_Sport_Id=:Event_Sport_Id');
        $stmt->bindValue('Event_Completed', false);
        $stmt->bindValue('Event_Gym_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0));
        $stmt->bindValue('Event_Sport_Id', 4);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function checkCalendarDetails()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Events WHERE Event_Id=:Event_Id');
        $stmt->bindValue('Event_Id', Request::post('data'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function confirmEvent()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Events SET Event_Completed=:Event_Completed WHERE Event_Id=:Event_Id');
        $stmt->bindValue('Event_Id', Request::post('Event_Id'));
        $stmt->bindValue('Event_Completed', 1);
        $stmt->execute();
    }

    public static function removeEvent()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('DELETE FROM Events WHERE Event_Id=:Event_Id');
        $stmt->bindValue('Event_Id', Request::post('Event_Id'));
        $stmt->execute();
    }

    public static function newEvent()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Events (Event_Start_Time, Event_End_Time, Event_Staff_Id, Event_Gym_Id, Event_Contact_Name, Event_Contact_Phone, Event_Sport_Id) VALUES (:Event_Start_Time, :Event_End_Time, :Event_Staff_Id, :Event_Gym_Id, :Event_Contact_Name, :Event_Contact_Phone, :Event_Sport_Id)');
        $stmt->bindValue('Event_Start_Time', date("Y-m-d H:00:00",strtotime(Request::post('Event_Start_Time'))));
        $stmt->bindValue('Event_End_Time', date("Y-m-d H:00:00",strtotime(Request::post('Event_End_Time'))));
        $stmt->bindValue('Event_Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Event_Gym_Id', $_SESSION["Gym_Id"]);
        $stmt->bindValue('Event_Contact_Name', Request::post('Event_Contact_Name'));
        $stmt->bindValue('Event_Contact_Phone', Request::post('Event_Contact_Phone'));
        $stmt->bindValue('Event_Sport_Id', 4);
        $stmt->execute();
    }
}