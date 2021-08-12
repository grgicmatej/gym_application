<?php


class User
{
    public static function allUsers()
    {
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

                                    WHERE Users_Gym.Gym_Id=:usersGym 
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersGym', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allUsersThreeMonths()
    {
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

                                    WHERE Users_Gym.Gym_Id=:usersGym 
                                    AND Users_Memberships.Users_Memberships_End_Date>:twoMonthPeriod
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersGym', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->bindValue('twoMonthPeriod', date('Y-m-d', strtotime("-60 days")));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allActiveUsers()
    {
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
                                    Users_Gym.Gym_Id=:usersGym
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersGym', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allUsersCount()
    {
        $tempData=self::allUsers();
        $array=[];
        foreach ($tempData as $data) {
            if (!in_array($usersMembershipsUsersId=$data->Users_Memberships_Users_Id, $array)) {
                array_push($array, $usersMembershipsUsersId=$data->Users_Memberships_Users_Id);
            } else {
                continue;
            }
        }

        return count($array);
    }

    public static function allActiveUsersCount()
    {
        $tempdata=self::allActiveUsers();
        $array=[];
        foreach ($tempdata as $data) {
            if (!in_array($usersMembershipsUsersId=$data->Users_Memberships_Users_Id, $array)) {
                array_push($array, $usersMembershipsUsersId=$data->Users_Memberships_Users_Id);
            } else {
                continue;
            }
        }
        return count($array);
    }

    public static function allInactiveUsersCount()
    {
        return self::allUsersCount() - self::allActiveUsersCount();
    }

    public static function currentMonthlyUsers()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT COUNT(Users_Id) AS newMonthlyUsers FROM Users WHERE 
                                        MONTH(Users_Registration)=:currentMonth 
                                        AND 
                                        YEAR(Users_Registration)=:currentYear');
        $stmt->bindValue('currentMonth', date('m'));
        $stmt->bindValue('currentYear', date('Y'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function previousMonthUsers()
    {
        $datestring=date('Y-m-d').' first day of last month';
        $dt=date_create($datestring);

        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT COUNT(Users_Id) AS previousMonthlyUsers FROM Users WHERE 
                                        DAY(Users_Registration)<=:currentDay
                                        AND
                                        MONTH(Users_Registration)=:previousMonth 
                                        AND 
                                        YEAR(Users_Registration)=:yearOfPreviousMonth        
                                        ');
        $stmt->bindValue('currentDay', date('d'));
        $stmt->bindValue('previousMonth', $dt->format('m'));
        $stmt->bindValue('yearOfPreviousMonth', $dt->format('Y'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function monthlyUserProportion()
    {
        return round((self::currentMonthlyUsers()->newMonthlyUsers/self::previousMonthUsers()->previousMonthlyUsers)*100, 2);
    }
}