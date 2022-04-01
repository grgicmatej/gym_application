<?php


class Dashboard
{
    public static function checkGymData($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:staffId AND Staff_Gym.Gym_Id=:gymId');
        $stmt->bindValue('staffId', Session::getInstance()->getUser()->Staff_Id ?? 0);
        $stmt->bindValue('gymId', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function changeGym()
    {
        $_SESSION['Gym_Id']=self::gymDataLimit1()->Gym_Id;
    }

    Public static function gymData()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:staffId
                                
                ');
        $stmt->bindValue('staffId', Session::getInstance()->getUser()->Staff_Id ?? 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    Public static function gymDataCount()
    {
        return count(self::gymData());
    }

    Public static function gymDataLimit1()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:staffId
                                        ORDER BY RAND() LIMIT 1  
                ');
        $stmt->bindValue('staffId', Session::getInstance()->getUser()->Staff_Id ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function gymName()
    {
        $data=self::checkGymData($_SESSION["Gym_Id"] ?? 0);
        $gymName= $data->Gym_Name ?? '' ;
        return $gymName;
    }
}