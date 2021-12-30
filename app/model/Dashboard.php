<?php


class Dashboard
{
    public static function checkGymData($id) // Uzima podatke od tražene teretane u vlasništvu Staff_Id
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:staffId AND Staff_Gym.Gym_Id=:gymId');
        $stmt->bindValue('staffId', isset(Session::getInstance()->getUser()->Staff_Id) ? Session::getInstance()->getUser()->Staff_Id : 0);
        $stmt->bindValue('gymId', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function changeGym()
    {
        $_SESSION['Gym_Id']=self::gymDataLimit1()->Gym_Id;
    }

    Public static function gymData() //Provjerava sve teretane koje su u vlasništvu Staff_Id
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
        $stmt->bindValue('staffId', isset(Session::getInstance()->getUser()->Staff_Id) ? Session::getInstance()->getUser()->Staff_Id : 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    Public static function gymDataCount()
    {
        return count(self::gymData());
    }

    Public static function gymDataLimit1() //Provjerava sve teretane koje su u vlasništvu Staff_Id sa limitom 1
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
        $stmt->bindValue('staffId', isset(Session::getInstance()->getUser()->Staff_Id) ? Session::getInstance()->getUser()->Staff_Id : 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function gymName()
    {
        $data=self::checkGymData(isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $gymName=empty($data->Gym_Name) ? '' : $data->Gym_Name;
        return $gymName;
    }
}