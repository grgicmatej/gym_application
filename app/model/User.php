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

    public static function lastUserMembershipExtension()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Users_Memberships ORDER BY Users_Memberships_Id DESC LIMIT 1 ');
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function newArrival($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Users_Arrivals
                            (
                            Users_Arrivals_User_Id,
                            Users_Arrivals_Week,
                            Users_Arrivals_Gym_Id
                            )
                            VALUES 
                            (
                            :usersArrivalsUserId,
                            :usersArrivalsWeek,
                            :usersArrivalsGymId
                            )
                        ');
        $stmt->bindValue('usersArrivalsUserId', $id);
        $stmt->bindValue('usersArrivalsWeek', date("oW", strtotime(date('Y-m-d'))));
        $stmt->bindValue('usersArrivalsGymId', $_SESSION["Gym_Id"]);
        $stmt->execute();
    }

    public static function newUserMembershipExtension($membershipData, $id)
    {

        $usersMembershipsStartDate=date_format(date_create(), 'Y.m.d');
        $usersMembershipsStartDatetemp=date_format(date_create(), 'd.m.Y');
        $dateSeconds=strtotime($usersMembershipsStartDatetemp) + ($membershipData->Memberships_Duration * 86400);
        $usersMembershipsEndDate=date('Y.m.d', $dateSeconds);
        $usersMembershipsCurentDate=date_format(date_create(), 'Y.m.d');

        $usersMembershipsMembershipActive = ($usersMembershipsCurentDate<=$usersMembershipsEndDate) ? 1 : 0;
            /*
        if ($usersMembershipsCurentDate <= $usersMembershipsEndDate) {
            $usersMembershipsMembershipActive=1;
        } else {
            $usersMembershipsMembershipActive=0;
        }
            */
        $db=Db::getInstance();
        $stmt=$db->prepare("
                            INSERT INTO Users_Memberships
                                (
                                Users_Memberships_Users_Id,
                                Users_Memberships_Membership_Name,
                                Users_Memberships_Start_Date,
                                Users_Memberships_End_Date,
                                Users_Memberships_Curent_Date,
                                Users_Memberships_Price,
                                Users_Memberships_Membership_Active,
                                Users_Memberships_Admin_Id,
                                Users_Memberships_Gym_Id
                                )
                                VALUES
                                (
                                :usersMembershipsUsersId,
                                :usersMembershipsMembershipName,
                                :usersMembershipsStartDate,
                                :usersMembershipsEndDate,
                                :usersMembershipsCurentDate,
                                :usersMembershipsPrice,
                                :usersMembershipsMembershipActive,
                                :usersMembershipsAdminId,
                                :usersMembershipsGymId
                                )
                            ");
        $stmt->bindValue('usersMembershipsUsersId', $id);
        $stmt->bindValue('usersMembershipsMembershipName', $membershipData->Memberships_Name);
        $stmt->bindValue('usersMembershipsStartDate', $usersMembershipsStartDate);
        $stmt->bindValue('usersMembershipsEndDate', $usersMembershipsEndDate);
        $stmt->bindValue('usersMembershipsCurentDate', $usersMembershipsCurentDate);
        $stmt->bindValue('usersMembershipsPrice', $membershipData->Memberships_Price);
        $stmt->bindValue('usersMembershipsMembershipActive', $usersMembershipsMembershipActive);
        $stmt->bindValue('usersMembershipsAdminId', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('usersMembershipsGymId', $_SESSION['Gym_Id']);
        $stmt->execute();
    }

    public static function newUserMembershipExtensionArchive($lastMembership, $membershipData, $id)
    {
        $usersMembershipsStartDate=date_format(date_create(), 'Y.m.d');
        $usersMembershipsStartDatetemp=date_format(date_create(), 'd.m.Y');
        $dateSeconds=strtotime($usersMembershipsStartDatetemp) + ($membershipData->Memberships_Duration * 86400);
        $usersMembershipsEndDate=date('Y.m.d', $dateSeconds);

        $db=Db::getInstance();
        $stmt=$db->prepare("
                            INSERT INTO Users_Memberships_Archive
                                (
                                Users_Memberships_Id,
                                Users_Memberships_Users_Id,
                                Users_Memberships_Membership_Id,
                                Users_Memberships_Membership_Name,
                                Users_Memberships_Start_Date,
                                Users_Memberships_End_Date,
                                Users_Memberships_Price,
                                Users_Memberships_Gym_Id,
                                Users_Memberships_Admin_Id
                                )
                                VALUES
                                (
                                :usersMembershipsId,
                                :usersMembershipsUsersId,
                                :usersMembershipsMembershipId,
                                :usersMembershipsMembershipName,
                                :usersMembershipsStartDate,
                                :usersMembershipsEndDate,
                                :usersMembershipsPrice,                                
                                :usersMembershipsGymId,
                                :usersMembershipsAdminId
                                )
                            ");
        $stmt->bindValue('usersMembershipsId', $lastMembership->Users_Memberships_Id);
        $stmt->bindValue('usersMembershipsUsersId', $id);
        $stmt->bindValue('usersMembershipsMembershipId', $membershipData->Memberships_Id);
        $stmt->bindValue('usersMembershipsMembershipName', $membershipData->Memberships_Name);
        $stmt->bindValue('usersMembershipsStartDate', $usersMembershipsStartDate);
        $stmt->bindValue('usersMembershipsEndDate', $usersMembershipsEndDate);
        $stmt->bindValue('usersMembershipsPrice', $membershipData->Memberships_Price);
        $stmt->bindValue('usersMembershipsGymId', $_SESSION['Gym_Id']);
        $stmt->bindValue('usersMembershipsAdminId', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }

    public static function viewUserData($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users.Users_City,
                                    Users.Users_Address,
                                    Users.Users_Phone,
                                    Users.Users_Email,
                                    Users.Users_Birthday,
                                    Users.Users_Oib,
                                    Users.Users_Gender,
                                    Users.Users_Reference,
                                    Users.Users_Company,
                                    Users.Users_Status,
                                    Users.Users_Registration,
                                    Users.Users_Photo,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Users_Id,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Users_Memberships.Users_Memberships_Admin_Id,
                                    Staff.Staff_Id,
                                    Staff.Staff_Name,
                                    Staff.Staff_Surname,
                                    Users_Gym.Gym_Id,
                                    Users_Gym.Users_Id
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    LEFT JOIN Staff             ON Staff.Staff_Id=Users_Memberships.Users_Memberships_Admin_Id
                                    LEFT JOIN Users_Gym         ON Users_Gym.Users_Id=Users.Users_Id

                                    WHERE Users.Users_Id=:usersId
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersId', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function viewUserEssentialData($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users.Users_City,
                                    Users.Users_Address,
                                    Users.Users_Phone,
                                    Users.Users_Email,
                                    Users.Users_Birthday,
                                    Users.Users_Photo,
                                    Users.Users_Status,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Users_Id,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Staff.Staff_Id,
                                    Staff.Staff_Name,
                                    Staff.Staff_Surname,
                                    Users_Gym.Gym_Id,
                                    Users_Gym.Users_Id
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    LEFT JOIN Staff             ON Staff.Staff_Id=Users_Memberships.Users_Memberships_Admin_Id
                                    LEFT JOIN Users_Gym         ON Users_Gym.Users_Id=Users.Users_Id

                                    WHERE Users.Users_Id=:usersId
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersId', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function viewUserEmail($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare("SELECT Users_Email FROM Users WHERE Users_Id=:Users_Id");
        $stmt->bindValue('Users_Id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function userArrivalCount($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT COUNT(Users_Arrivals_Id) AS countrow FROM Users_Arrivals WHERE 
                                        Users_Arrivals_User_Id=:usersArrivalsUserId 
                                        AND
                                        (Users_Arrivals_Week)=:usersArrivalsWeek
                                        ');
        $stmt->bindValue('usersArrivalsUserId', $id);
        $stmt->bindValue('usersArrivalsWeek', date("oW", strtotime(date('Y-m-d'))));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function essentialUserData($id)
    {
        $objMerged = (object) array_merge(
            (array) self::viewUserEssentialData($id), (array) self::userArrivalCount($id));

        return $objMerged;
    }
}