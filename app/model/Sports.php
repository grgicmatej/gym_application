<?php


class Sports
{
    public static function checkSportsName()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Sport_Settings_Name FROM Sport_Settings WHERE Sport_Settings_Sport_Id=:Sport_Settings_Sport_Id AND Sport_Settings_Gym_Id=:Sport_Settings_Gym_Id');
        $stmt->bindValue('Sport_Settings_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('Sport_Settings_Sport_Id', Request::post('Sport_Settings_Sport_Id'));
        $stmt->execute();
        return $stmt->fetch();
    }
}