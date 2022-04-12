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
                                            YEAR(Sales_Date)=:currentYear');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('currentYear', date('Y'));
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
                                            YEAR(Sales_Date)=:previousYear');
            $stmt->bindValue('monthData', $m);
            $stmt->bindValue('previousYear', date("Y",strtotime("-1 year")));
            $stmt->execute();
            $userDataPreviousYear[]=$stmt->fetch();
        }
        return $userDataPreviousYear;
    }
}