<?php


class Statistics
{
    public static function monthlyIncome()
    {
        $gymId = isset($_SESSION["Gym_Id"]) ? $_SESSION["Gym_Id"] : 0;
        $month=date('m');
        $year=date('Y');
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS Users_Memberships_Price_Month FROM Sales 
                                        WHERE MONTH(Sales_Date)=:Current_Month 
                                        AND YEAR(Sales_Date)=:Current_Year
                                        AND Sales_Gym_Id=:Sales_Gym_Id
                                        ');
        $stmt->bindValue('Current_Month', $month);
        $stmt->bindValue('Current_Year', $year);
        $stmt->bindValue('Sales_Gym_Id', $gymId);
        $stmt->execute();
        return $stmt->fetch();
    }
}