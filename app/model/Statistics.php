<?php


class Statistics
{
    public static function monthlyIncome()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS Users_Memberships_Price_Month FROM Sales 
                                        WHERE MONTH(Sales_Date)=:Current_Month 
                                        AND YEAR(Sales_Date)=:Current_Year
                                        AND Sales_Gym_Id=:Sales_Gym_Id
                                        ');
        $stmt->bindValue('Current_Month', date('m'));
        $stmt->bindValue('Current_Year', date('Y'));
        $stmt->bindValue('Sales_Gym_Id',  $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function monthsInYear()
    {
        for ($i=1; $i<=date('m'); $i++){
            $months[]=$i;
        }
        return $months;
    }

    public static function yearlyStats()
    {
        $userData=[];
        $months=[1,2,3,4,5,6,7,8,9,10,11,12];
        foreach ($months as $m){
            $db=Db::getInstance();
            $stmt=$db->prepare('SELECT COUNT(Users_Id) AS userData FROM Users WHERE 
                                            MONTH(Users_Registration)=:monthData 
                                            AND 
                                            YEAR(Users_Registration)=:currentYear');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('currentYear', date('Y'));
            $stmt->execute();
            $userData[]=$stmt->fetch();
        }
        return $userData;
    }

    public static function yearlyStatsPreviousYear()
    {

        $userDataPreviousYear=[];
        $months=[1,2,3,4,5,6,7,8,9,10,11,12];
        foreach ($months as $m){
            $db=Db::getInstance();
            $stmt=$db->prepare('SELECT COUNT(Users_Id) AS userData FROM Users WHERE 
                                            MONTH(Users_Registration)=:monthData 
                                            AND 
                                            YEAR(Users_Registration)=:previousYear');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('previousYear', date("Y",strtotime("-1 year")));
            $stmt->execute();
            $userDataPreviousYear[]=$stmt->fetch();
        }
        return $userDataPreviousYear;
    }
}