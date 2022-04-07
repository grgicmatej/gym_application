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

    public static function popularMemberships()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT Users_Memberships_Membership_Name, COUNT(Users_Memberships_Membership_Name) AS membershipsCount
                                    FROM Users_Memberships_Archive 
                                    WHERE YEAR(Users_Memberships_Start_Date)=:Users_Memberships_Start_Date
                                    AND Users_Memberships_Gym_Id=:Users_Memberships_Gym_Id
                                    GROUP BY Users_Memberships_Membership_Name');
        $stmt->bindValue('Users_Memberships_Gym_Id', $_SESSION["Gym_Id"] ?? 0);
        $stmt->bindValue('Users_Memberships_Start_Date', date('Y'));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function ageOfUsers()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT SUM(CASE WHEN YEAR(Users_Birthday) < 20 THEN 1 ELSE 0 END) AS data1,
                                    SUM(CASE WHEN YEAR(Users_Birthday) BETWEEN 21 AND 30 THEN 1 ELSE 0 END) AS data2,
                                    SUM(CASE WHEN YEAR(Users_Birthday) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) AS data3,
                                    SUM(CASE WHEN YEAR(Users_Birthday) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) AS data4,
                                    SUM(CASE WHEN YEAR(Users_Birthday) BETWEEN 51 AND 60 THEN 1 ELSE 0 END) AS data5,
                                    SUM(CASE WHEN YEAR(Users_Birthday) > 61 THEN 1 ELSE 0 END) AS data6
                                    FROM Users');
        $stmt->execute();
        return $stmt->fetchAll();
    }

}