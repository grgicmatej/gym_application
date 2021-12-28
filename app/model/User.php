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

    public static function allUsersSearch()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id as Users_Id_Main,
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

                                    WHERE Users_Gym.Gym_Id=:usersGym AND 
                                    (Users.Users_Id LIKE :parametar_id
                                    OR Users.Users_Name LIKE :parametar 
                                    OR Users.Users_Surname LIKE :parametar)
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersGym', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->bindValue('parametar_id', '%'.Request::post('query').'%');
        $stmt->bindValue('parametar', trim(Request::post('query'), " ").'%');
        $stmt->execute();

        $uData = $stmt->fetchAll();
        $array=[];


         foreach ($uData as $data){
             if (!in_array($Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id, $array)){
                 array_push($array, $Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id);?>
                 <tr>
                     <?php
                     if (!empty($data->Users_Memberships_Start_Date)):
                         $timestamp = strtotime($data->Users_Memberships_Start_Date);
                         $realdate_Start = date("d.m.Y", $timestamp);

                         $timestamp = strtotime($data->Users_Memberships_End_Date);
                         $realdate_End = date("d.m.Y", $timestamp);
                     else:
                         $realdate_Start = "";
                         $realdate_End = "";
                     endif;
                     ?>
                     <td class="text-center" id="<?=$data->Users_Id_Main?>_usersId"><?=substr(strrchr($data->Users_Id_Main, '-'), 1)?></td>
                     <td class="text-center" id="<?=$data->Users_Id_Main?>_usersName"><?=$data->Users_Name." ".$data->Users_Surname?></td>
                     <td class="text-center" id="<?=$data->Users_Id_Main?>_membershipsName"><?=$data->Users_Memberships_Membership_Name?></td>
                     <td id="<?=$data->Users_Id_Main?>_membershipsStatus" style="background-color: <?= $data->Users_Memberships_Membership_Active? "#74C687":"#E87C87" ?>; color: white; font-weight: bolder" class="text-center">
                         <?= $data->Users_Memberships_Membership_Active? "Da" : "Ne"?>
                     </td>
                     <td class="text-center" id="<?=$data->Users_Id_Main?>_membershipsStartDate"><?=$realdate_Start?></td>
                     <td class="text-center" id="<?=$data->Users_Id_Main?>_membershipsEndDate"><?=$realdate_End?></td>
                     <td class="text-center profileData" id="i_<?= $data->Users_Id_Main ?>">
                         <p>
                             <a class="submitlink linkanimation "> Pregled <i class="fad fa-user ml-10"></i></a>
                         </p>
                     </td>
                 </tr>
                 <?php

             }else{
             continue;
             }
         }






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

        $usersMembershipsStartDate=date_format(date_create(), 'Y.m.d');
        $usersMembershipsStartDatetemp=date_format(date_create(), 'd.m.Y');
        $dateSeconds=strtotime($usersMembershipsStartDatetemp) + ($membershipData->Memberships_Duration * 86400);
        $usersMembershipsEndDate=date('Y.m.d', $dateSeconds);
        $usersMembershipsCurentDate=date_format(date_create(), 'Y.m.d');

        $usersMembershipsMembershipActive = ($usersMembershipsCurentDate<=$usersMembershipsEndDate) ? 1 : 0;

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