<?php


class User
{
    public static function allUsersSearch()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id as Users_Id_Main,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    WHERE 
                                    Users_Memberships.Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id
                                    AND
                                    (Users.Users_Id LIKE :parametar_id
                                    OR Users.Users_Surname LIKE :parametar
                                    OR CONCAT(Users.Users_Name, :spacing, Users.Users_Surname) LIKE :parametar
                                    )
                                    ORDER BY Users.Users_Id ASC
                                    ');
        $stmt->bindValue('Users_Memberships_Gym_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0));
        $stmt->bindValue('parametar_id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0).'-'.Request::post('query').'%');
        $stmt->bindValue('parametar', trim(Request::post('query'), " ").'%');
        $stmt->bindValue('spacing', ' ');

        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function allUsersCount()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT COUNT(Users_Id) as allUsersCount FROM Users_Gym WHERE Gym_Id=:Gym_Id');
        $stmt->bindValue('Gym_Id', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
        return $stmt->fetch();
    }
    public static function allActiveUsersCount()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                        COUNT(Users_Memberships_Users_Id) as activeUsersCount
                                            FROM Users_Memberships
                                            LEFT JOIN Users_Gym ON Users_Gym.Users_Id=Users_Memberships.Users_Memberships_Users_Id
                                            WHERE 
                                            Users_Memberships.Users_Memberships_End_Date > Users_Memberships.Users_Memberships_Curent_Date
                                            AND 
                                            Users_Gym.Gym_Id=:Gym_Id 
                                    ');
        $stmt->bindValue('Gym_Id', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allInactiveUsersCount()
    {
        return self::allUsersCount()->allUsersCount - self::allActiveUsersCount()->activeUsersCount;
    }

    public static function addUserGymRegistration()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Users_Gym 
                                (
                                Users_Id,
                                Gym_Id
                                )
                                VALUES
                                (
                                :Users_Id,
                                :Gym_Id
                                )
                                ');
        $stmt->bindValue('Users_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0).'-'.Request::post('Users_Id'));
        $stmt->bindValue('Gym_Id', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
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

    public static function checkUsersId()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT 
                                    Users.Users_Id,
                                    Users_Gym.Gym_Id
                                    FROM Users
                                    LEFT JOIN Users_Gym ON Users_Gym.Users_Id=Users.Users_Id
                                    WHERE (Users.Users_Id=:Users_Id AND Users_Gym.Gym_Id=:Gym_Id) OR (Users.Users_Id=:Users_Id_New AND Users_Gym.Gym_Id=:Gym_Id)');
        $stmt->bindValue('Gym_Id', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->bindValue('Users_Id', Request::post('Users_Id'));
        $stmt->bindValue('Users_Id_New', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0).'-'.Request::post('Users_Id'));
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            return false;
        }else{
            return true;
        }
    }

    public static function previousMonthUsers()
    {
        $dt=date_create(date('Y-m-d').' first day of last month');

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

    public static function newUser($usersPhoto)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare("INSERT INTO Users
                                (
                                    Users_Id,
                                    Users_Name, 
                                    Users_Surname,
                                    Users_City,
                                    Users_Address,
                                    Users_Phone,
                                    Users_Email,
                                    Users_Birthday,
                                    Users_Oib,
                                    Users_Gender,
                                    Users_Reference,
                                    Users_Company,
                                    Users_Status,
                                    Users_Registration,
                                    Users_Photo
                                )
                                VALUES 
                                (
                                    :Users_Id,
                                    :Users_Name, 
                                    :Users_Surname,
                                    :Users_City,
                                    :Users_Address,
                                    :Users_Phone,
                                    :Users_Email,
                                    :Users_Birthday,
                                    :Users_Oib,
                                    :Users_Gender,
                                    :Users_Reference,
                                    :Users_Company,
                                    :Users_Status,
                                    :Users_Registration,
                                    :Users_Photo
                                )
                                ");
        $stmt->bindValue('Users_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0).'-'.Request::post('Users_Id'));
        $stmt->bindValue('Users_Name', Request::post('Users_Name'));
        $stmt->bindValue('Users_Surname', Request::post('Users_Surname'));
        $stmt->bindValue('Users_City', Request::post('Users_City'));
        $stmt->bindValue('Users_Address', Request::post('Users_Address'));
        $stmt->bindValue('Users_Phone', Request::post('Users_Phone'));
        $stmt->bindValue('Users_Email', Request::post('Users_Email'));
        $stmt->bindValue('Users_Birthday', Request::post('Users_Birthday'));
        $stmt->bindValue('Users_Oib', Request::post('Users_Oib'));
        $stmt->bindValue('Users_Gender', Request::post('Users_Gender'));
        $stmt->bindValue('Users_Reference', Request::post('Users_Reference'));
        $stmt->bindValue('Users_Company', !empty(Request::post('Users_Company'))? Request::post('Users_Company') : '');
        $stmt->bindValue('Users_Status', Request::post('Users_Status'));
        $stmt->bindValue('Users_Registration', date("Y-m-d"));
        $stmt->bindValue('Users_Photo', $usersPhoto);
        $stmt->execute();
    }

    public static function newUserMembershipExtension($membershipData, $id)
    {
        $usersMembershipsEndDate=date('Y.m.d', strtotime(date_format(date_create(), 'd.m.Y')) + ($membershipData->Memberships_Duration * 86400));

        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships
                            SET
                            Users_Memberships_Membership_Name=:Users_Memberships_Membership_Name,
                            Users_Memberships_Start_Date=NOW(),
                            Users_Memberships_End_Date=:Users_Memberships_End_Date,
                            Users_Memberships_Curent_Date=NOW(),
                            Users_Memberships_Price=:Users_Memberships_Price,
                            Users_Memberships_Membership_Active=:Users_Memberships_Membership_Active,
                            Users_Memberships_Admin_Id=:Users_Memberships_Admin_Id
                            WHERE
                            Users_Memberships_Users_Id=:Users_Memberships_Users_Id
                            AND
                            Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id
                            
        
        ');

        $stmt->bindValue('Users_Memberships_Users_Id', $id);
        $stmt->bindValue('Users_Memberships_Membership_Name', $membershipData->Memberships_Name);
        $stmt->bindValue('Users_Memberships_End_Date', $usersMembershipsEndDate);
        $stmt->bindValue('Users_Memberships_Price', $membershipData->Memberships_Price);
        $stmt->bindValue('Users_Memberships_Membership_Active', 1);
        $stmt->bindValue('Users_Memberships_Admin_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Users_Memberships_Gym_Id', $_SESSION['Gym_Id']);
        $stmt->execute();
    }

    public static function newUserMembershipExtensionArchive($lastMembership, $membershipData, $id)
    {
        $usersMembershipsEndDate=date('Y.m.d', strtotime(date_format(date_create(), 'd.m.Y')) + ($membershipData->Memberships_Duration * 86400));

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
                                :Users_Memberships_Id,
                                :Users_Memberships_Users_Id,
                                :Users_Memberships_Membership_Id,
                                :Users_Memberships_Membership_Name,
                                NOW(),
                                :Users_Memberships_End_Date,
                                :Users_Memberships_Price,                                
                                :Users_Memberships_Gym_Id,
                                :Users_Memberships_Admin_Id
                                )
                            ");
        $stmt->bindValue('Users_Memberships_Id', $lastMembership->Users_Memberships_Id);
        $stmt->bindValue('Users_Memberships_Users_Id', $id);
        $stmt->bindValue('Users_Memberships_Membership_Id', $membershipData->Memberships_Id);
        $stmt->bindValue('Users_Memberships_Membership_Name', $membershipData->Memberships_Name);
        $stmt->bindValue('Users_Memberships_End_Date', $usersMembershipsEndDate);
        $stmt->bindValue('Users_Memberships_Price', $membershipData->Memberships_Price);
        $stmt->bindValue('Users_Memberships_Gym_Id', $_SESSION['Gym_Id']);
        $stmt->bindValue('Users_Memberships_Admin_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }

    public static function newUserFirstMembershipExtension()
    {
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
                                :Users_Memberships_Users_Id,
                                :Users_Memberships_Membership_Name,
                                :Users_Memberships_Start_Date,
                                :Users_Memberships_End_Date,
                                :Users_Memberships_Curent_Date,
                                :Users_Memberships_Price,
                                :Users_Memberships_Membership_Active,
                                :Users_Memberships_Admin_Id,
                                :Users_Memberships_Gym_Id
                                )
                            ");
        $stmt->bindValue('Users_Memberships_Users_Id', (isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0).'-'.Request::post('Users_Id'));
        $stmt->bindValue('Users_Memberships_Membership_Name', '-');
        $stmt->bindValue('Users_Memberships_Start_Date', date_format(date_create(), 'Y.m.d'));
        $stmt->bindValue('Users_Memberships_End_Date', date_format(date_create(), 'Y.m.d'));
        $stmt->bindValue('Users_Memberships_Curent_Date', date_format(date_create(), 'Y.m.d'));
        $stmt->bindValue('Users_Memberships_Price', 0);
        $stmt->bindValue('Users_Memberships_Membership_Active', 0);
        $stmt->bindValue('Users_Memberships_Admin_Id', Session::getInstance()->getUser()->Staff_Id);
        $stmt->bindValue('Users_Memberships_Gym_Id', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->execute();
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