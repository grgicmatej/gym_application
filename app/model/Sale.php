<?php


class Sale
{
    public static function newMembershipSale($membershipData)
    {
        $db = Db::getInstance();
        $stmt = $db->prepare('INSERT INTO Sales 
                            (
                            Sales_Gym_Id,
                            Sales_Item_Name,
                            Sales_Price,
                            Sales_Date
                            )
                            VALUES
                            (
                            :salesGymId,
                            :salesItemName,
                            :salesPrice,
                            :salesDate
                            )
                            ');
        $stmt->bindValue('salesGymId', $_SESSION['Gym_Id']);
        $stmt->bindValue('salesItemName', $membershipData->Memberships_Name);
        $stmt->bindValue('salesPrice', $membershipData->Memberships_Price);
        $stmt->bindValue('salesDate', date('Y-m-d'));
        $stmt->execute();
    }
}