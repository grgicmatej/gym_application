<?php


class User
{
    public static function allUsers()
    {
        if (isset($_COOKIE['Gym_Id'])){
            $Users_Gym=$_COOKIE['Gym_Id'];
        }else{
            $Users_Gym=0;
        }
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Users_Id,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Users_Gym.Gym_Id,
                                    Users_Gym.Users_Id
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    LEFT JOIN Users_Gym         ON Users_Gym.Users_Id=Users.Users_Id

                                    WHERE Users_Gym.Gym_Id=:Users_Gym
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('Users_Gym', $Users_Gym);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allActiveUsers()
    {
        if (isset($_COOKIE['Gym_Id'])){
            $Users_Gym=$_COOKIE['Gym_Id'];
        }else{
            $Users_Gym=0;
        }

        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Users_Id,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Users_Memberships.Users_Memberships_Curent_Date,
                                    Users_Gym.Gym_Id,
                                    Users_Gym.Users_Id
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    LEFT JOIN Users_Gym         ON Users_Gym.Users_Id=Users.Users_Id

                                    WHERE 
                                    Users_Memberships.Users_Memberships_End_Date > Users_Memberships.Users_Memberships_Curent_Date 
                                    AND 
                                    Users_Gym.Gym_Id=:Users_Gym
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('Users_Gym', $Users_Gym);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allUsersCount()
    {
        $tempData=self::allUsers();
        $array=[];
        foreach ($tempData as $data){
            if (!in_array($usersMembershipsUsersId = $data->Users_Memberships_Users_Id, $array)){
                array_push($array, $usersMembershipsUsersId = $data->Users_Memberships_Users_Id);
            }else{
                continue;
            }
        }

        return count($array);
    }

    public static function allActiveUsersCount()
    {
        $tempdata=self::allActiveUsers();
        $array=[];
        foreach ($tempdata as $data){
            if (!in_array($Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id, $array)){
                array_push($array, $Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id);
            }else{
                continue;
            }
        }
        return count($array);
    }

    public static function allInactiveUsersCount()
    {
        return self::allUsersCount()-self::allActiveUsersCount();
    }
}