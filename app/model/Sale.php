<?php


class Sale extends Sender
{
    public static function newMembershipSale($membershipData)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('INSERT INTO Sales 
                            (
                             Sales_Gym_Id,
                             Sales_Item_Id,
                             Sales_Item_Name,
                             Sales_Price,
                             Sales_Date,
                             Sales_Staff_Id
                            )
                            VALUES
                            (
                             :salesGymId,
                             :salesItemId,
                             :salesItemName,
                             :salesPrice,
                             :salesDate,
                             :salesStaffId
                            )
                            ');
        $stmt->bindValue('salesGymId', $_SESSION['Gym_Id']);
        $stmt->bindValue('salesItemId', $membershipData->Memberships_Id);
        $stmt->bindValue('salesItemName', $membershipData->Memberships_Name);
        $stmt->bindValue('salesPrice', $membershipData->Memberships_Price);
        $stmt->bindValue('salesDate', date('Y-m-d'));
        $stmt->bindValue('salesStaffId', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }

    public static function existingMembershipSale()
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('INSERT INTO Sales 
                            (
                             Sales_Gym_Id,
                             Sales_Item_Id,
                             Sales_Item_Name,
                             Sales_Price,
                             Sales_Date,
                             Sales_Staff_Id
                            )
                            VALUES
                            (
                             :salesGymId,
                             :salesItemId,
                             :salesItemName,
                             :salesPrice,
                             :salesDate,
                             :salesStaffId
                            )
                            ');
        $stmt->bindValue('salesGymId', $_SESSION['Gym_Id']);
        $stmt->bindValue('salesItemId', '0');
        $stmt->bindValue('salesItemName', Request::post('Users_Memberships_Membership_Name'));
        $stmt->bindValue('salesPrice', Request::post('Users_Memberships_Price'));
        $stmt->bindValue('salesDate', date('Y-m-d'));
        $stmt->bindValue('salesStaffId', Session::getInstance()->getUser()->Staff_Id);
        $stmt->execute();
    }
}