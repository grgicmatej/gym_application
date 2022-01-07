<?php


class Timers
{
    public static function checkTimer()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Timers WHERE Timers_Completed=:Timers_Completed AND Timers_Sport_Id=:Timers_Sport_Id AND Timers_Gym_Id=:Timers_Gym_Id ');
        $stmt->bindValue('Timers_Gym_Id', $_SESSION["Gym_Id"]);
        $stmt->bindValue('Timers_Sport_Id', Request::post('sportId'));
        $stmt->bindValue('Timers_Completed', false);
        $stmt->execute();
        if (count($stmt->fetchAll()) == 0){
            return true;
        } else {
            return false;
        }
    }

    public static function startTimer($sportPrice)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Timers 
                                        (
                                        Timers_Staff_Id,
                                        Timers_Price,
                                        Timers_Gym_Id,
                                        Timers_Sport_Id
                                        ) 
                                        VALUES 
                                        (
                                        :Timers_Staff_Id,
                                        :Timers_Price,
                                        :Timers_Gym_Id,
                                        :Timers_Sport_Id
                                        )');
        $stmt->bindValue('Timers_Staff_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Timers_Price', $sportPrice);
        $stmt->bindValue('Timers_Gym_Id', $_SESSION["Gym_Id"]);
        $stmt->bindValue('Timers_Sport_Id', Request::post('sportId'));
        $stmt->execute();
    }

    public static function checkPrice()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Sport_Settings_Price FROM Sport_Settings WHERE Sport_Settings_Gym_Id=:Sport_Settings_Gym_Id AND Sport_Settings_Sport_Id=:Sport_Settings_Sport_Id AND Sport_Settings_Sport_Active=:Sport_Settings_Sport_Active');
        $stmt->bindValue('Sport_Settings_Gym_Id', $_SESSION["Gym_Id"]);
        $stmt->bindValue('Sport_Settings_Sport_Active', true);
        $stmt->bindValue('Sport_Settings_Sport_Id', Request::post('sportId'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function checkStarTime()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Timers_Start_Time FROM Timers WHERE Timers_Gym_Id=:Timers_Gym_Id AND Timers_Completed=:Timers_Completed AND Timers_Sport_Id=:Timers_Sport_Id');
        $stmt->bindValue('Timers_Gym_Id', $_SESSION["Gym_Id"]);
        $stmt->bindValue('Timers_Completed', false);
        $stmt->bindValue('Timers_Sport_Id', Request::post('sportId'));
        $stmt->execute();
        return $stmt->fetch();
    }
}