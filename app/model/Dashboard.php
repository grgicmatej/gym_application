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

    public static function changeGym()
    {
        $data=self::gymDataLimit1();
        foreach ($data as $d) {
            $gymId = $d->Gym_Id;
        }

        unset($_COOKIE['Gym_Id']);
        setcookie('Gym_Id', null, -1, '/');
        $cookieName='Gym_Id';
        $cookieValue=$gymId;
        setcookie($cookieName, $cookieValue, time() + (86400 * 30), '/');
        $_SESSION["Gym_Id"] = $cookieValue;
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

    Public static function gymDataCount()
    {
        return count(self::gymData());
    }

    Public static function gymDataLimit1() //Provjerava sve teretane koje su u vlasništvu Staff_Id sa limitom 1
    {
        $Staff_Id=Session::getInstance()->getUser()->Staff_Id;
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT  
                                        Gym.Gym_Id,
                                        Gym.Gym_Name,
                                        Staff_Gym.Gym_Id
                                        FROM Gym
                                        INNER JOIN Staff_Gym ON Staff_Gym.Gym_Id=Gym.Gym_Id
                                        WHERE Staff_Gym.Staff_Id=:Staff_Id
                                        ORDER BY RAND() LIMIT 1  
                ');
        $stmt->bindValue('Staff_Id', $Staff_Id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function gymName()
    {
        $gymId = isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0;
        $data=self::checkGymData($gymId);
        foreach ($data as $d){
            $gymName=$d->Gym_Name;
        }
        $gymName = empty($gymName) ? '' : $gymName;
        return $gymName;
    }
}