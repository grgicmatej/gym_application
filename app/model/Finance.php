<?php

class Finance
{
    public static function yearlyStatsFinances()
    {
        $userData=[];
        $months=[1,2,3,4,5,6,7,8,9,10,11,12];
        foreach ($months as $m){
            $db=Db::getInstance();
            $stmt=$db->prepare('SELECT SUM(Sales_Price) AS userFinanceData FROM Sales WHERE 
                                            MONTH(Sales_Date)=:monthData 
                                            AND 
                                            YEAR(Sales_Date)=:currentYear
                                            AND
                                            Sales_Gym_Id=:Sales_Gym_Id');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('currentYear', date('Y'));
            $stmt->bindValue('Sales_Gym_Id', $_SESSION["Gym_Id"] ?? 0);

            $stmt->execute();
            $userData[]=$stmt->fetch();
        }
        return $userData;
    }

    public static function yearlyStatsPreviousYearFinances()
    {

        $userDataPreviousYear=[];
        $months=[1,2,3,4,5,6,7,8,9,10,11,12];
        foreach ($months as $m){
            $db=Db::getInstance();
            $stmt=$db->prepare('SELECT SUM(Sales_Price) AS userFinanceData FROM Sales WHERE 
                                            MONTH(Sales_Date)=:monthData 
                                            AND 
                                            YEAR(Sales_Date)=:previousYear
                                            AND
                                            Sales_Gym_Id=:Sales_Gym_Id');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('previousYear', date("Y",strtotime("-1 year")));
            $stmt->bindValue('Sales_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
            $stmt->execute();
            $userDataPreviousYear[]=$stmt->fetch();
        }
        return $userDataPreviousYear;
    }

    public static function yearlyIncome()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS Users_Memberships_Price_Year FROM Sales 
                                        WHERE YEAR(Sales_Date)=:Current_Year
                                        AND Sales_Gym_Id=:Sales_Gym_Id
                                        ');
        $stmt->bindValue('Current_Year', date('Y'));
        $stmt->bindValue('Sales_Gym_Id',  $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

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

    public static function yesterdayIncome()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS Users_Memberships_Price_Yesterday FROM Sales 
                                        WHERE DAY(Sales_Date)=:Current_Day
                                        AND MONTH(Sales_Date)=:Current_Month 
                                        AND YEAR(Sales_Date)=:Current_Year
                                        AND Sales_Gym_Id=:Sales_Gym_Id
                                        ');
        $stmt->bindValue('Current_Day', date('d',strtotime("-1 days")));
        $stmt->bindValue('Current_Month', date('m'));
        $stmt->bindValue('Current_Year', date('Y'));
        $stmt->bindValue('Sales_Gym_Id',  $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function dailyIncome()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS Users_Memberships_Price_Day FROM Sales 
                                        WHERE DAY(Sales_Date)=:Current_Day
                                        AND MONTH(Sales_Date)=:Current_Month 
                                        AND YEAR(Sales_Date)=:Current_Year
                                        AND Sales_Gym_Id=:Sales_Gym_Id
                                        ');
        $stmt->bindValue('Current_Day', date('d'));
        $stmt->bindValue('Current_Month', date('m'));
        $stmt->bindValue('Current_Year', date('Y'));
        $stmt->bindValue('Sales_Gym_Id',  $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function yearlyIncomeMemberships()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Sales_Item_Name, SUM(Sales_Price) AS salesSum
                                    FROM Sales 
                                    WHERE YEAR(Sales_Date)=:Sales_Date
                                    AND Sales_Gym_Id=:Sales_Gym_Id
                                    GROUP BY Sales_Item_Name
                                    ORDER BY salesSum DESC 
                                    LIMIT 15
                                    ');
        $stmt->bindValue('Sales_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('Sales_Date', date('Y'));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function yearlyIncomeOther()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Sales_Warehouse_Item_Name, SUM(Sales_Warehouse_Price) AS salesSum
                                    FROM Sales_Warehouse 
                                    WHERE YEAR(Sales_Warehouse_Date)=:Sales_Warehouse_Date
                                    AND Sales_Warehouse_Gym_Id=:Sales_Warehouse_Gym_Id
                                    GROUP BY Sales_Warehouse_Item_Name
                                    ORDER BY salesSum DESC 
                                    LIMIT 10
                                    ');
        $stmt->bindValue('Sales_Warehouse_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('Sales_Warehouse_Date', date('Y'));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function incomeOnSpecificDateMemberships()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Price) AS membershipsSale, Sales_Date FROM Sales WHERE Sales_Date=:Sales_Date AND Sales_Gym_Id=:Sales_Gym_Id');
        $stmt->bindValue('Sales_Date', Request::post('incomeDates'));
        $stmt->bindValue('Sales_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function incomeOnSpecificDateOther()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(Sales_Warehouse_Price) AS otherSale FROM Sales_Warehouse WHERE Sales_Warehouse_Date=:Sales_Date AND Sales_Warehouse_Gym_Id=:Sales_Gym_Id');
        $stmt->bindValue('Sales_Date', Request::post('incomeDates'));
        $stmt->bindValue('Sales_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function incomeOnSpecificDate()
    {
        $objMerged = (object)array_merge(
            (array)self::incomeOnSpecificDateMemberships(), (array)self::incomeOnSpecificDateOther());

        return $objMerged;
    }
}