<?php


class Membership
{
    public static function timeUpdate()
    {
        $date=date_create();
        $usersMembershipsCurentDate=date_format($date, 'Y.m.d');
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Curent_Date=:Users_Memberships_Curent_Date');
        $stmt->bindValue('Users_Memberships_Curent_Date', $usersMembershipsCurentDate);
        $stmt->execute();

        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Membership_Active=:Users_Memberships_Membership_Active
                                            WHERE
                                            Users_Memberships_Curent_Date > Users_Memberships_End_Date
                                ');
        $stmt->bindValue('Users_Memberships_Membership_Active', 0);
        $stmt->execute();
    }
}