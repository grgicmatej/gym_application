<?php


class User extends Membership
{
    public static function addNewUserMembership($id)
    {
        if (Request::post('usersMembershipsMembershipName') == "disabled"){
            return false;
        }else{
            self::newUserMembershipExtension(self::selectMembership(), $id);
            self::newUserMembershipExtensionArchive(self::lastUserMembershipExtension($id), self::selectMembership(), $id);

            self::newMembershipSale(self::selectMembership());

            self::deleteRecipient($id);
            self::addNewRecipient(self::viewUserEmail($id), $id, self::membershipEndDate(self::selectMembership()));
            return true;
        }
    }

    public static function addCurrentUserMembership($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Membership_Name=:Users_Memberships_Membership_Name, Users_Memberships_Price=:Users_Memberships_Price, Users_Memberships_Start_Date=:Users_Memberships_Start_Date, Users_Memberships_End_Date=:Users_Memberships_End_Date WHERE Users_Memberships_Users_Id=:Users_Memberships_Users_Id');
        $stmt->bindValue('Users_Memberships_Membership_Name', Request::post('Users_Memberships_Membership_Name'));
        $stmt->bindValue('Users_Memberships_Price', Request::post('Users_Memberships_Price'));
        $stmt->bindValue('Users_Memberships_Start_Date', Request::post('Users_Memberships_Start_Date'));
        $stmt->bindValue('Users_Memberships_End_Date', Request::post('Users_Memberships_End_Date'));
        $stmt->bindValue('Users_Memberships_Users_Id', $id);
        $stmt->execute();
    }

    public static function addCurrentUserMembershipExtensionArchive($lastMembership, $id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("
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
                                :Users_Memberships_Start_Date,
                                :Users_Memberships_End_Date,
                                :Users_Memberships_Price,                                
                                :Users_Memberships_Gym_Id,
                                :Users_Memberships_Admin_Id
                                )
                            ");
        $stmt->bindValue('Users_Memberships_Id', $lastMembership->Users_Memberships_Id);
        $stmt->bindValue('Users_Memberships_Users_Id', $id);
        $stmt->bindValue('Users_Memberships_Membership_Id', 'custom');
        $stmt->bindValue('Users_Memberships_Membership_Name', Request::post('Users_Memberships_Membership_Name'));
        $stmt->bindValue('Users_Memberships_Start_Date', Request::post('Users_Memberships_Start_Date'));
        $stmt->bindValue('Users_Memberships_End_Date', Request::post('Users_Memberships_End_Date'));
        $stmt->bindValue('Users_Memberships_Price', Request::post('Users_Memberships_Price'));
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->bindValue('Users_Memberships_Admin_Id', 1);
        $stmt->execute();
    }

    public static function allUsersSearch()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT
                                    Users.Users_Id as Users_Id_Main,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Memberships_Pause.Memberships_Pause_Active
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    LEFT JOIN Memberships_Pause ON Memberships_Pause.Memberships_Pause_User_Id=Users.Users_Id
                                    WHERE 
                                    Users_Memberships.Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id
                                    AND
                                    (Users.Users_Id LIKE :parametar_id
                                    OR Users.Users_Surname LIKE :parametar
                                    OR CONCAT(Users.Users_Name, :spacing, Users.Users_Surname) LIKE :parametar
                                    )
                                    ORDER BY Users.Users_Id ASC
                                    ');
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->bindValue('parametar_id', (1) . '-' . Request::post('query') . '%');
        $stmt->bindValue('parametar', trim(Request::post('query'), " ") . '%');
        $stmt->bindValue('spacing', ' ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allUsersCount()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT COUNT(Users_Id) as allUsersCount FROM Users_Gym WHERE Gym_Id=:Gym_Id');
        $stmt->bindValue('Gym_Id', 1);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allActiveUsersCount()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT
                                        COUNT(Users_Memberships_Users_Id) as activeUsersCount
                                            FROM Users_Memberships
                                            LEFT JOIN Users_Gym ON Users_Gym.Users_Id=Users_Memberships.Users_Memberships_Users_Id
                                            WHERE 
                                            Users_Memberships.Users_Memberships_End_Date > Users_Memberships.Users_Memberships_Curent_Date
                                            AND 
                                            Users_Gym.Gym_Id=:Gym_Id 
                                    ');
        $stmt->bindValue('Gym_Id', 1);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function allInactiveUsersCount()
    {
        return self::allUsersCount()->allUsersCount - self::allActiveUsersCount()->activeUsersCount;
    }

    public static function addUserGymRegistration($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('INSERT INTO Users_Gym 
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
        $stmt->bindValue('Users_Id', 1 . '-' . ($id === NULL ? Request::post('Users_Id') :  $id));
        $stmt->bindValue('Gym_Id', 1);
        $stmt->execute();
    }

    public static function currentMonthlyUsers()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT COUNT(Users_Id) AS newMonthlyUsers FROM Users WHERE 
                                        MONTH(Users_Registration)=:currentMonth 
                                        AND 
                                        YEAR(Users_Registration)=:currentYear');
        $stmt->bindValue('currentMonth', '04');
        $stmt->bindValue('currentYear', '2022');
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function checkUsersId()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT 
                                    Users.Users_Id,
                                    Users_Gym.Gym_Id
                                    FROM Users
                                    LEFT JOIN Users_Gym ON Users_Gym.Users_Id=Users.Users_Id
                                    WHERE (Users.Users_Id=:Users_Id AND Users_Gym.Gym_Id=:Gym_Id) OR (Users.Users_Id=:Users_Id_New AND Users_Gym.Gym_Id=:Gym_Id)');
        $stmt->bindValue('Gym_Id', 1);
        $stmt->bindValue('Users_Id', Request::post('Users_Id'));
        $stmt->bindValue('Users_Id_New', (1) . '-' . Request::post('Users_Id'));
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkUserMemberships()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT Users_Memberships_Membership_Name, Users_Memberships_Start_Date, Users_Memberships_End_Date, Staff_Name, Staff_Surname FROM Users_Memberships_Archive LEFT JOIN Staff ON Users_Memberships_Archive.Users_Memberships_Admin_Id = Staff.Staff_Id WHERE Users_Memberships_Users_Id=:Users_Memberships_Users_Id AND Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id ORDER BY Users_Memberships_Archive_Id DESC');
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->bindValue('Users_Memberships_Users_Id', Request::post('Users_Memberships_Users_Id'));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function checkPausedMembership()
    {
        if (empty(self::pausedMembership(Request::post('userId')))){
            return true;
        } else {
            return false;
        }
    }

    public static function editUserPrepare($id)
    {
        if ($id !== (1 .'-'.Request::post('Users_Id'))) {
            if (self::checkUsersId()){
                self::editUser($id);
                self::updateUsersId($id);
                self::updateUsersArrivals($id);
                self::updateUsersGym($id);
                self::updateUsersMemberships($id);
                self::updateUsersMembershipsArchive($id);
                return true;
            } else {
                return false;
            }
        } else {
            self::editUser($id);
            return true;
        }
    }

    public static function editUser($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users SET 
                                     Users_Name=:Users_Name, 
                                     Users_Surname=:Users_Surname, 
                                     Users_Email=:Users_Email, 
                                     Users_Phone=:Users_Phone, 
                                     Users_Address=:Users_Address, 
                                     Users_City=:Users_City, 
                                     Users_Oib=:Users_Oib, 
                                     Users_Birthday=:Users_Birthday, 
                                     Users_Gender=:Users_Gender, 
                                     Users_Status=:Users_Status, 
                                     Users_Reference=:Users_Reference, 
                                     Users_Company=:Users_Company 
                                    WHERE Users_Id=:Users_Id');
        $stmt->bindValue('Users_Name', Request::post('Users_Name'));
        $stmt->bindValue('Users_Surname', Request::post('Users_Surname'));
        $stmt->bindValue('Users_Email', Request::post('Users_Email'));
        $stmt->bindValue('Users_Phone', Request::post('Users_Phone'));
        $stmt->bindValue('Users_Address', Request::post('Users_Address'));
        $stmt->bindValue('Users_City', Request::post('Users_City'));
        $stmt->bindValue('Users_Oib', Request::post('Users_Oib'));
        $stmt->bindValue('Users_Birthday', Request::post('Users_Birthday'));
        $stmt->bindValue('Users_Gender', Request::post('Users_Gender'));
        $stmt->bindValue('Users_Status', Request::post('Users_Status'));
        $stmt->bindValue('Users_Reference', Request::post('Users_Reference'));
        $stmt->bindValue('Users_Company', Request::post('Users_Company') ?? '');
        $stmt->bindValue('Users_Id', $id);
        $stmt->execute();
    }

    public static function editMembershipUser($id)
    {
        self::addCurrentUserMembership($id);
        self::addCurrentUserMembershipExtensionArchive(self::lastUserMembershipExtension($id), $id);

        self::existingMembershipSale();

        self::deleteRecipient($id);
        self::addNewRecipientFromExistingMembership(self::viewUserEmail($id), $id);
    }

    public static function essentialUserData($id)
    {
        $objMerged = (object)array_merge(
            (array)self::viewUserEssentialData($id), (array)self::userArrivalCount($id));

        return $objMerged;
    }

    public static function lastUserMembershipExtension($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT * FROM Users_Memberships WHERE Users_Memberships_Users_Id=:Users_Memberships_Users_Id ORDER BY Users_Memberships_Id DESC LIMIT 1 ');
        $stmt->bindValue('Users_Memberships_Users_Id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function monthlyUserProportion()
    {
        return round((self::currentMonthlyUsers()->newMonthlyUsers / (self::previousMonthUsers()->previousMonthlyUsers != 0 ? self::previousMonthUsers()->previousMonthlyUsers : 1)) * 100, 2 );
    }

    public static function newArrival($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('INSERT INTO Users_Arrivals
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
        $stmt->bindValue('usersArrivalsWeek', date("oW", strtotime('2022-04-29')));
        $stmt->bindValue('usersArrivalsGymId', 1);
        $stmt->execute();
    }

    public static function newUser($usersPhoto, $id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("INSERT INTO Users
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
        $stmt->bindValue('Users_Id',  (1) . '-' . ($id === NULL ? Request::post('Users_Id') :  $id));
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
        $stmt->bindValue('Users_Company', Request::post('Users_Company') ?? '');
        $stmt->bindValue('Users_Status', Request::post('Users_Status'));
        $stmt->bindValue('Users_Registration', date("Y-m-d"));
        $stmt->bindValue('Users_Photo', $usersPhoto);
        $stmt->execute();
    }

    public static function newUserMembershipExtension($membershipData, $id)
    {
        $usersMembershipsEndDate = date('Y.m.d', strtotime('2022-04-29') + ($membershipData->Memberships_Duration * 86400));

        $db = Db::getInstance();
        $stmt = $db->prepare('UPDATE Users_Memberships
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
        $stmt->bindValue('Users_Memberships_Admin_Id', 1);
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->execute();
    }

    public static function newUserMembershipExtensionArchive($lastMembership, $membershipData, $id)
    {
        $usersMembershipsEndDate = date('Y.m.d', strtotime('2022-04-29') + ($membershipData->Memberships_Duration * 86400));

        $db = Db::getInstance();
        $stmt = $db->prepare("
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
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->bindValue('Users_Memberships_Admin_Id', 1);
        $stmt->execute();
    }

    public static function newUserFirstMembershipExtension($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("
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
        $stmt->bindValue('Users_Memberships_Users_Id', (1) . '-' . ($id === NULL ? Request::post('Users_Id') :  $id));
        $stmt->bindValue('Users_Memberships_Membership_Name', '-');
        $stmt->bindValue('Users_Memberships_Start_Date', '2022-04-29');
        $stmt->bindValue('Users_Memberships_End_Date', '2022-04-29');
        $stmt->bindValue('Users_Memberships_Curent_Date', '2022-04-29');
        $stmt->bindValue('Users_Memberships_Price', 0);
        $stmt->bindValue('Users_Memberships_Membership_Active', 1);
        $stmt->bindValue('Users_Memberships_Admin_Id', 1);
        $stmt->bindValue('Users_Memberships_Gym_Id', 1);
        $stmt->execute();
    }

    public static function previousMonthUsers()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('SELECT COUNT(Users_Id) AS previousMonthlyUsers FROM Users WHERE 
                                        DAY(Users_Registration)<=:currentDay
                                        AND
                                        MONTH(Users_Registration)=:previousMonth 
                                        AND 
                                        YEAR(Users_Registration)=:yearOfPreviousMonth        
                                        ');
        $stmt->bindValue('currentDay', '29');
        $stmt->bindValue('previousMonth', '03');
        $stmt->bindValue('yearOfPreviousMonth', '2022');
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function pauseUser()
    {
        if (self::checkPausedMembership()){
            self::pauseMembership(self::viewUserEssentialData(Request::post('userId')));
            self::pauseMembershipArchive(self::pausedMembership(Request::post('userId')), self::viewUserEssentialData(Request::post('userId')));
            return false;
        }else{
            self::updateMembership(self::viewUserEssentialData(Request::post('userId')), self::timeDifference(self::pausedMembership(Request::post('userId'))));
            self::updateMembershipArchive(self::viewUserEssentialData(Request::post('userId')), self::timeDifference(self::pausedMembership(Request::post('userId'))));
            self::resumeMembership();
            self::resumeMembershipArchive();
            return true;
        }
    }

    public static function pauseMembership($membershipData)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("INSERT INTO Memberships_Pause 
                                (Memberships_Pause_User_Id, Memberships_Pause_Membership_Id, Memberships_Pause_Staff_Id, Memberships_Pause_Start_Date, Memberships_Pause_Active)
                                VALUES
                                (:Memberships_Pause_User_Id, :Memberships_Pause_Membership_Id, :Memberships_Pause_Staff_Id, NOW(), :Memberships_Pause_Active)");
        $stmt->bindValue('Memberships_Pause_User_Id', $membershipData->Users_Id);
        $stmt->bindValue('Memberships_Pause_Membership_Id', $membershipData->Users_Memberships_Id);
        $stmt->bindValue('Memberships_Pause_Staff_Id',1);
        $stmt->bindValue('Memberships_Pause_Active', 1);
        $stmt->execute();
    }

    public static function pauseMembershipArchive($pauseMembershipData, $membershipData)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare("INSERT INTO Memberships_Pause_Archive 
                                (Memberships_Pause_Id, Memberships_Pause_User_Id, Memberships_Pause_Membership_Id, Memberships_Pause_Staff_Id, Memberships_Pause_Start_Date, Memberships_Pause_Active)
                                VALUES
                                (:Memberships_Pause_Id, :Memberships_Pause_User_Id, :Memberships_Pause_Membership_Id, :Memberships_Pause_Staff_Id, NOW(), :Memberships_Pause_Active)");
        $stmt->bindValue('Memberships_Pause_Id', $pauseMembershipData->Memberships_Pause_Id);
        $stmt->bindValue('Memberships_Pause_User_Id', $membershipData->Users_Id);
        $stmt->bindValue('Memberships_Pause_Membership_Id', $membershipData->Users_Memberships_Id);
        $stmt->bindValue('Memberships_Pause_Staff_Id', 1);
        $stmt->bindValue('Memberships_Pause_Active', 1);
        $stmt->execute();
    }

    public static function pausedMembership($userId)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships_Pause WHERE 
                                            Memberships_Pause_User_Id=:Memberships_Pause_User_Id 
                                            AND 
                                            Memberships_Pause_Active=:Memberships_Pause_Active
                                            ');
        $stmt->bindValue('Memberships_Pause_Active', 1);
        $stmt->bindValue('Memberships_Pause_User_Id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function resumeMembership()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("DELETE FROM Memberships_Pause WHERE Memberships_Pause_User_Id=:Memberships_Pause_User_Id");
        $stmt->bindValue('Memberships_Pause_User_Id', Request::post('userId'));
        $stmt->execute();
    }

    public static function resumeMembershipArchive()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare("UPDATE Memberships_Pause_Archive SET Memberships_Pause_End_Date=NOW(), Memberships_Pause_Active=false WHERE Memberships_Pause_User_Id=:Memberships_Pause_User_Id");
        $stmt->bindValue('Memberships_Pause_User_Id', Request::post('userId'));
        $stmt->execute();
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
        $stmt->bindValue('usersArrivalsWeek', date("oW", strtotime('2022-04-29')));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function updateUsersId($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users SET
                                Users_Id=:Users_Id_New
                                WHERE
                                Users_Id=:Users_Id
                                ');
        $stmt->bindValue('Users_Id', $id);
        $stmt->bindValue('Users_Id_New', (1)."-".Request::post('Users_Id'));
        $stmt->execute();
    }

    public static function updateUsersArrivals($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Arrivals SET
                                Users_Arrivals_User_Id=:Users_Id_New
                                WHERE
                                Users_Arrivals_User_Id=:Users_Id
                                ');
        $stmt->bindValue('Users_Id', $id);
        $stmt->bindValue('Users_Id_New', (1)."-".Request::post('Users_Id'));
        $stmt->execute();
    }

    public static function updateUsersGym($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Gym SET
                                Users_Id=:Users_Id_New
                                WHERE
                                Users_Id=:Users_Id
                                ');
        $stmt->bindValue('Users_Id', $id);
        $stmt->bindValue('Users_Id_New', (1)."-".Request::post('Users_Id'));
        $stmt->execute();
    }

    public static function updateUsersMemberships($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET
                                Users_Memberships_Users_Id=:Users_Id_New
                                WHERE
                                Users_Memberships_Users_Id=:Users_Id
                                ');
        $stmt->bindValue('Users_Id', $id);
        $stmt->bindValue('Users_Id_New',(1)."-".Request::post('Users_Id'));
        $stmt->execute();
    }

    public static function updateUsersMembershipsArchive($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships_Archive SET
                                Users_Memberships_Users_Id=:Users_Id_New
                                WHERE
                                Users_Memberships_Users_Id=:Users_Id
                                ');
        $stmt->bindValue('Users_Id', $id);
        $stmt->bindValue('Users_Id_New', (1)."-".Request::post('Users_Id'));
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
                                    Users.Users_Gender,
                                    Users.Users_Oib,
                                    Users.Users_Reference,
                                    Users.Users_Company,
                                    Users_Memberships.Users_Memberships_Id,
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
}