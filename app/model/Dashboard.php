<?php


class Dashboard
{
    public static function checkGymData($id) // Uzima podatke od tražene teretane u vlasništvu Staff_Id
    {
        if (isset(Session::getInstance()->getUser()->Staff_Id)){
            $Staff_Id=Session::getInstance()->getUser()->Staff_Id;
        }else{
            $Staff_Id=0;
        }
        $Gym_Id=$id;
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:Staff_Id AND Staff_Gym.Gym_Id=:Gym_Id');
        $stmt->bindValue('Staff_Id', $Staff_Id);
        $stmt->bindValue('Gym_Id', $Gym_Id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    Public static function gymData() //Provjerava sve teretane koje su u vlasništvu Staff_Id
    {
        if (isset(Session::getInstance()->getUser()->Staff_Id)){
            $Staff_Id=Session::getInstance()->getUser()->Staff_Id;
        }else{
            $Staff_Id=0;
        }

        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:Staff_Id
                                
                ');
        $stmt->bindValue('Staff_Id', $Staff_Id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}