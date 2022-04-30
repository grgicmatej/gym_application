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
        $stmt->bindValue('staffId', 1);
        $stmt->bindValue('gymId', 1);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function changeGym($id = null)
    {
        if ($id){
            if (self::checkGymId($id)){
                $_SESSION['Gym_Id']= 1;
            }else{
                $_SESSION['Gym_Id']= 1;
            }
        }
        $_SESSION['Gym_Id']= 1;
    }

    public static function checkGymId($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Staff_Gym WHERE Staff_Id=:Staff_Id AND Gym_Id=:Gym_Id');
        $stmt->bindValue('Staff_Id',1);
        $stmt->bindValue('Gym_Id', 1);
        if ($stmt->rowCount()>0) {
            return true;
        }
        else{
            return false;
        }
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
        $stmt->bindValue('staffId', 1);
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
        $stmt->bindValue('staffId', 1);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function gymName()
    {
        $data=self::checkGymData(1);
        $gymName= $data->Gym_Name ?? '' ;
        return $gymName;
    }
}