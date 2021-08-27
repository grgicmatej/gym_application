<?php


class Membership
{
    public static function allActiveMemberships()
    {

        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Gym_Id=:membershipsGymId AND Memberships_Active=:membershipsActive AND Memberships_Visible=:membershipsVisible');
        $stmt->bindValue('membershipsGymId', isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0);
        $stmt->bindValue('membershipsActive', 1);
        $stmt->bindValue('membershipsVisible', 1);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function membershipEndDate($membershipData)
    {
        $usersMembershipsStartDatetemp=date_format(date_create(), 'd.m.Y');
        $dateSeconds=strtotime($usersMembershipsStartDatetemp) + ($membershipData->Memberships_Duration * 86400);
        $usersMembershipsEndDate=date('y-m-d', $dateSeconds);
        return $usersMembershipsEndDate;
    }

    public static function timeUpdate()
    {
        $usersMembershipsCurentDate=date_format(date_create(), 'Y.m.d');
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Curent_Date=:UsersMembershipsCurentDate');
        $stmt->bindValue('UsersMembershipsCurentDate', $usersMembershipsCurentDate);
        $stmt->execute();

        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Membership_Active=:Users_Memberships_Membership_Active
                                            WHERE
                                            Users_Memberships_Curent_Date > Users_Memberships_End_Date
                                ');
        $stmt->bindValue('Users_Memberships_Membership_Active', 0);
        $stmt->execute();
    }

    public static function selectMembership()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Name=:membershipsName');
        $stmt->bindValue('membershipsName', Request::post('usersMembershipsMembershipName'));
        $stmt->execute();
        return $stmt->fetch();
    }
}