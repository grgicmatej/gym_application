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
        return $stmt->fetchAll();
    }

    public static function changeGym()
    {
        $data=self::gymDataLimit1();
        foreach ($data as $d) {
            $gymId=$d->Gym_Id;
        }
        $_SESSION['Gym_Id']=$gymId;

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
        return $stmt->fetchAll();
    }

    public static function gymName()
    {
        $gymId=isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0;
        $data=self::checkGymData($gymId);
        foreach ($data as $d){
            $gymName=$d->Gym_Name;
        }
        $gymName=empty($gymName) ? '' : $gymName;
        return $gymName;
    }
}