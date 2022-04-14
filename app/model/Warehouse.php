<?php

class Warehouse
{
    public static function allWarehouseItems()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT *, (Warehouse_Item_Count-Warehouse_Item_Sold_Count) AS remainingWarehouseCount FROM Warehouse WHERE Warehouse_Gym_Id=:Warehouse_Gym_Id');
        $stmt->bindValue('Warehouse_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function viewWarehouseItem($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Warehouse WHERE Warehouse_Id=:Warehouse_Id and Warehouse_Gym_Id=:Warehouse_Gym_Id');
        $stmt->bindValue('Warehouse_Id', $id);
        $stmt->bindValue('Warehouse_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function editWarehouseItemData($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Warehouse SET 
                                    Warehouse_Item_Name=:Warehouse_Item_Name, 
                                    Warehouse_Item_Price=:Warehouse_Item_Price, 
                                    Warehouse_Item_Count=:Warehouse_Item_Count
                                    WHERE
                                    Warehouse_Id=:Warehouse_Id
                                    AND
                                    Warehouse_Gym_Id=:Warehouse_Gym_Id
                                    ');

        $stmt->bindValue('Warehouse_Item_Name', Request::post('Warehouse_Item_Name'));
        $stmt->bindValue('Warehouse_Item_Price', Request::post('Warehouse_Item_Price'));
        $stmt->bindValue('Warehouse_Item_Count', Request::post('Warehouse_Item_Count'));
        $stmt->bindValue('Warehouse_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->bindValue('Warehouse_Id', $id);
        $stmt->execute();
    }

    public static function deleteWarehouseItem()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('DELETE FROM Warehouse WHERE Warehouse_Id=:Warehouse_Id AND Warehouse_Gym_Id=:Warehouse_Gym_Id');
        $stmt->bindValue('Warehouse_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->bindValue('Warehouse_Id', Request::post('warehouseId'));
        $stmt->execute();
    }

    public static function resetWarehouseItem()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Warehouse SET Warehouse_Item_Sold_Count=:Warehouse_Item_Sold_Count WHERE Warehouse_Id=:Warehouse_Id AND Warehouse_Gym_Id=:Warehouse_Gym_Id');
        $stmt->bindValue('Warehouse_Item_Sold_Count', 0);
        $stmt->bindValue('Warehouse_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->bindValue('Warehouse_Id', Request::post('warehouseId'));
        $stmt->execute();
    }
}