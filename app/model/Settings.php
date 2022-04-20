<?php

class Settings
{
    public static function gymSettings()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sport_Settings WHERE Sport_Settings_Gym_Id=:Gym_Id
                                   ');
        $stmt->bindValue('Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function gymSettingsCash()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Cash_Register WHERE Cash_Register_Gym_Id=:Gym_Id
                                   ');
        $stmt->bindValue('Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function editCashRegisterAmount()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Cash_Register SET Cash_Register_Amount=:Cash_Register_Amount WHERE Cash_Register_Gym_Id=:Cash_Register_Gym_Id');
        $stmt->bindValue('Cash_Register_Amount', Request::post('Cash_Register_Amount'));
        $stmt->bindValue('Cash_Register_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
    }

    public static function settingsSportEditPrep($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sport_Settings WHERE Sport_Settings_Id=:Sport_Settings_Id AND Sport_Settings_Gym_Id=:Sport_Settings_Gym_Id');
        $stmt->bindValue('Sport_Settings_Id', $id);
        $stmt->bindValue('Sport_Settings_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function settingsSportEdit($id)
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Sport_Settings SET Sport_Settings_Name=:Sport_Settings_Name, Sport_Settings_Price=:Sport_Settings_Price WHERE Sport_Settings_Id=:Sport_Settings_Id AND Sport_Settings_Gym_Id=:Sport_Settings_Gym_Id');
        $stmt->bindValue('Sport_Settings_Id', $id);
        $stmt->bindValue('Sport_Settings_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->bindValue('Sport_Settings_Name', Request::post('Sport_Settings_Name'));
        $stmt->bindValue('Sport_Settings_Price', Request::post('Sport_Settings_Price'));
        $stmt->execute();
    }

    public static function SettingsSportActiveStatus()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('UPDATE Sport_Settings SET Sport_Settings_Sport_Active=:Sport_Settings_Sport_Active WHERE Sport_Settings_Id=:Sport_Settings_Id AND Sport_Settings_Gym_Id=:Sport_Settings_Gym_Id');
        $stmt->bindValue('Sport_Settings_Sport_Active', Request::post('sportActiveValue'));
        $stmt->bindValue('Sport_Settings_Id', Request::post('sportId'));
        $stmt->bindValue('Sport_Settings_Gym_Id', $_SESSION['Gym_Id'] ?? 0);
        $stmt->execute();
    }
}