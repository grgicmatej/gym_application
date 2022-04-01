<?php


class Membership extends Timers
{
    public static function allMemberships()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Gym_Id=:membershipsGymId AND Memberships_Visible=:membershipsVisible');
        $stmt->bindValue('membershipsGymId', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('membershipsVisible', 1);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function allActiveMemberships()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Gym_Id=:membershipsGymId AND Memberships_Active=:membershipsActive AND Memberships_Visible=:membershipsVisible');
        $stmt->bindValue('membershipsGymId', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('membershipsActive', 1);
        $stmt->bindValue('membershipsVisible', 1);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function changeActiveStatus()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Memberships SET Memberships_Active=:Memberships_Active WHERE Memberships_Id=:Memberships_Id');
        $stmt->bindValue('Memberships_Active', (self::checkActiveStatusMembership() ? 0 : 1));
        $stmt->bindValue('Memberships_Id', Request::post('Memberships_Id'));
        $stmt->execute();
        return self::checkActiveStatusMembership();
    }

    public static function checkActiveStatusMembership()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Id=:Memberships_Id AND Memberships_Active=true');
        $stmt->bindValue('Memberships_Id', Request::post('Memberships_Id'));
        $stmt->execute();
        return $stmt->rowCount();
    }

    public  static function deleteMembership()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Memberships SET Memberships_Visible=false WHERE Memberships_Id=:Memberships_Id');
        $stmt->bindValue('Memberships_Id', Request::post('Memberships_Id'));
        $stmt->execute();
    }

    public static function editMembership($id)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('UPDATE Memberships SET 
                                    Memberships_Name=:Memberships_Name, 
                                    Memberships_Price=:Memberships_Price, 
                                    Memberships_Duration=:Memberships_Duration
                                    WHERE
                                    Memberships_Id=:Memberships_Id');
        $stmt->bindValue('Memberships_Name', Request::post('Memberships_Name'));
        $stmt->bindValue('Memberships_Price', Request::post('Memberships_Price'));
        $stmt->bindValue('Memberships_Duration', Request::post('Memberships_Duration'));
        $stmt->bindValue('Memberships_Id', $id);
        $stmt->execute();
        return true;
    }

    public static function membershipEndDate($membershipData)
    {
        $usersMembershipsStartDatetemp=date_format(date_create(), 'd.m.Y');
        $dateSeconds=strtotime($usersMembershipsStartDatetemp) + ($membershipData->Memberships_Duration * 86400);
        $usersMembershipsEndDate=date('y-m-d', $dateSeconds);
        return $usersMembershipsEndDate;
    }

    public static function newMembeship()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('INSERT INTO Memberships 
                            (
                             Memberships_Name,
                             Memberships_Price,
                             Memberships_Duration,
                             Memberships_Gym_Id,
                             Memberships_Active,
                             Memberships_Visible
                             )
                            VALUES
                            (
                             :Memberships_Name,
                             :Memberships_Price,
                             :Memberships_Duration,
                             :Memberships_Gym_Id,
                             true,
                             true
                             )
                            ');
        $stmt->bindValue('Memberships_Name', Request::post('Memberships_Name'));
        $stmt->bindValue('Memberships_Price', Request::post('Memberships_Price'));
        $stmt->bindValue('Memberships_Duration', Request::post('Memberships_Duration'));
        $stmt->bindValue('Memberships_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
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

    public static function selectMembershipById()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Memberships WHERE Memberships_Id=:Memberships_Id');
        $stmt->bindValue('Memberships_Id', Request::post('Memberships_Id'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function timeUpdate()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Curent_Date=NOW()');
        $stmt->execute();

        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Membership_Active=:Users_Memberships_Membership_Active
                                            WHERE
                                            Users_Memberships_Curent_Date > Users_Memberships_End_Date
                                ');
        $stmt->bindValue('Users_Memberships_Membership_Active', 0);
        $stmt->execute();
    }

    public static function updateMembership($membershipData, $membershipEndDate)
   {
       $db=Db::getInstance();
       $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_End_Date=:Users_Memberships_End_Date WHERE Users_Memberships_Id=:Users_Memberships_Id');
       $stmt->bindValue('Users_Memberships_End_Date', date('Y-m-d', strtotime($membershipData->Users_Memberships_End_Date.'+'.$membershipEndDate.' days')));
       $stmt->bindValue('Users_Memberships_Id',$membershipData->Users_Memberships_Id);
       $stmt->execute();
   }

    public static function updateMembershipArchive($membershipData, $membershipEndDate)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships_Archive SET Users_Memberships_End_Date=:Users_Memberships_End_Date WHERE Users_Memberships_Id=:Users_Memberships_Id');
        $stmt->bindValue('Users_Memberships_End_Date', date('Y-m-d', strtotime($membershipData->Users_Memberships_End_Date.'+'.$membershipEndDate.' days')));
        $stmt->bindValue('Users_Memberships_Id',$membershipData->Users_Memberships_Id);
        $stmt->execute();
    }
}