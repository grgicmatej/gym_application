<?php


class TestController extends SecurityController
{
    // Ovo je za ciscenje baze
    public function ciscenjeBaze()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT
                                    Users.Users_Id as Users_Id_Main,
                                    Users.Users_Name,
                                    Users.Users_Surname,
                                    Users_Memberships.Users_Memberships_Id,
                                    Users_Memberships.Users_Memberships_Membership_Name,
                                    Users_Memberships.Users_Memberships_Membership_Active,
                                    Users_Memberships.Users_Memberships_Users_Id,
                                    Users_Memberships.Users_Memberships_Start_Date,
                                    Users_Memberships.Users_Memberships_End_Date,
                                    Users_Memberships.Users_Memberships_Gym_Id
                                    FROM
                                    Users
                                    LEFT JOIN Users_Memberships ON Users_Memberships.Users_Memberships_Users_Id=Users.Users_Id
                                    ORDER BY Users_Memberships.Users_Memberships_Id DESC
                                    ');
        $stmt->bindValue('usersGym', 1);
        $stmt->bindValue('parametar_id', '%'.Request::post('query').'%');
        $stmt->bindValue('parametar', trim(Request::post('query'), " ").'%');
        $stmt->execute();

        $uData = $stmt->fetchAll();
        $array=[];

        $arrayZaBrisanje=[];

        foreach ($uData as $data){
            if (!in_array($Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id, $array)){
                array_push($array, $Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id);?>

                <?php

            }else{
                array_push($arrayZaBrisanje, $data -> Users_Memberships_Id);
            }

        }


        echo count($arrayZaBrisanje);


        foreach ($arrayZaBrisanje as $a) {
            $db=Db::getInstance();
            $stmt=$db->prepare('DELETE FROM Users_Memberships WHERE Users_Memberships_Id=:Users_Memberships_Id');
            $stmt->bindValue('Users_Memberships_Id', $a);
            $stmt->execute();
        }
    }

    /*
    public function randomiziranje()
    {
        self::randomImena();
        self::randomclanarine();
        self::randomclanarineArhiva();
        self::randomsales();
        self::randomsalesWarehouse();
        echo "Randomiziranje podataka gotovo";

    }
    public function randomImena()
    {
        $names = file('randData/names.txt', FILE_IGNORE_NEW_LINES);
        $surnames = file('randData/surnames.txt', FILE_IGNORE_NEW_LINES);
        $city = file('randData/city.txt', FILE_IGNORE_NEW_LINES);
        $address = file('randData/address.txt', FILE_IGNORE_NEW_LINES);
        $phone = file('randData/phone.txt', FILE_IGNORE_NEW_LINES);
        $email = file('randData/email.txt', FILE_IGNORE_NEW_LINES);
        $oib = file('randData/oib.txt', FILE_IGNORE_NEW_LINES);

        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Users');
        $stmt->execute();
        $dataUsers=$stmt->fetchAll();
        foreach ($dataUsers as $d){
            $stmt=$db->prepare('UPDATE Users SET 
                        Users_Name=:Users_Name, 
                        Users_Surname=:Users_Surname, 
                        Users_City=:Users_City, 
                        Users_Address=:Users_Address, 
                        Users_Phone=:Users_Phone,
                        Users_Email=:Users_Email,
                        Users_Oib=:Users_Oib,
                        Users_Company=:Users_Company
                        WHERE Users_Id=:Users_Id');
            $stmt->bindValue('Users_Id', $d->Users_Id);
            $stmt->bindValue('Users_Name', $names[array_rand($names, 1)]);
            $stmt->bindValue('Users_Surname', $surnames[array_rand($surnames, 1)]);
            $stmt->bindValue('Users_City', $city[array_rand($city, 1)]);
            $stmt->bindValue('Users_Address', $address[array_rand($address, 1)]);
            $stmt->bindValue('Users_Phone', $phone[array_rand($phone, 1)]);
            $stmt->bindValue('Users_Email', $email[array_rand($email, 1)]);
            $stmt->bindValue('Users_Oib', $oib[array_rand($oib, 1)]);
            $stmt->bindValue('Users_Company', $names[array_rand($names, 1)].' d.o.o');

            $stmt->execute();
        }
    }

    public function randomclanarine()
    {
        $memberships = file('randData/memberships.txt', FILE_IGNORE_NEW_LINES);
        $db = Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Users_Memberships');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $d){
            $stmt=$db->prepare('UPDATE Users_Memberships SET Users_Memberships_Membership_Name=:Users_Memberships_Membership_Name, Users_Memberships_Admin_Id=:Users_Memberships_Admin_Id	WHERE Users_Memberships_Id=:Users_Memberships_Id');
            $stmt->bindValue('Users_Memberships_Membership_Name', $memberships[array_rand($memberships, 1)]);
            $stmt->bindValue('Users_Memberships_Admin_Id', rand(1,5));
            $stmt->bindValue('Users_Memberships_Id', $d->Users_Memberships_Id);
            $stmt->execute();
        }
    }

    public function randomclanarineArhiva()
    {
        $memberships = file('randData/memberships.txt', FILE_IGNORE_NEW_LINES);
        $db = Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Users_Memberships_Archive');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $d){
            $stmt=$db->prepare('UPDATE Users_Memberships_Archive SET Users_Memberships_Membership_Name=:Users_Memberships_Membership_Name, Users_Memberships_Admin_Id=:Users_Memberships_Admin_Id	WHERE Users_Memberships_Id=:Users_Memberships_Id');
            $stmt->bindValue('Users_Memberships_Membership_Name', $memberships[array_rand($memberships, 1)]);
            $stmt->bindValue('Users_Memberships_Admin_Id', rand(1,5));
            $stmt->bindValue('Users_Memberships_Id', $d->Users_Memberships_Id);
            $stmt->execute();
        }
    }

    public function randomsales()
    {
        $memberships = file('randData/memberships.txt', FILE_IGNORE_NEW_LINES);
        $db = Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sales');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $d){
            $item_key = array_rand($memberships, 1);
            $item = $memberships[$item_key];
            $stmt=$db->prepare('UPDATE Sales SET Sales_Item_Id=:Sales_Item_Id, Sales_Item_Name=:Sales_Item_Name, Sales_Staff_Id=:Sales_Staff_Id WHERE Sales_Id=:Sales_Id');
            $stmt->bindValue('Sales_Item_Id', $item_key);
            $stmt->bindValue('Sales_Item_Name', $item);
            $stmt->bindValue('Sales_Staff_Id', rand(1,5));
            $stmt->bindValue('Sales_Id', $d->Sales_Id);
            $stmt->execute();
        }
    }

    public function randomsalesWarehouse()
    {
        $warehouse = file('randData/warehouse.txt', FILE_IGNORE_NEW_LINES);
        $db = Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sales_Warehouse');
        $stmt->execute();
        $data = $stmt->fetchAll();

        foreach ($data as $d){
            $item_key = array_rand($warehouse, 1);
            $item = $warehouse[$item_key];
            $stmt=$db->prepare('UPDATE Sales_Warehouse SET Sales_Warehouse_Item_Id=:Sales_Warehouse_Item_Id, Sales_Warehouse_Item_Name=:Sales_Warehouse_Item_Name, Sales_Warehouse_Staff_Id=:Sales_Warehouse_Staff_Id WHERE Sales_Warehouse_Id=:Sales_Warehouse_Id');
            $stmt->bindValue('Sales_Warehouse_Item_Id', $item_key);
            $stmt->bindValue('Sales_Warehouse_Item_Name', $item);
            $stmt->bindValue('Sales_Warehouse_Staff_Id', rand(1,5));
            $stmt->bindValue('Sales_Warehouse_Id', $d->Sales_Warehouse_Id);
            $stmt->execute();
        }
    }

    // delete data


    public function brisanje()
    {
        self::deleteUsers();
        self::deletesales();
        self::deletesalesWarehouse();
        echo "Brisanje gotovo";
    }

    public function deleteUsers()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Users');
        $stmt->execute();
        $data=$stmt->fetchAll();
        $obrisaniid=array();
        foreach ($data as $d)
        {
            $random = rand(1,2);
            if ($random == 1){
                $stmt=$db->prepare('DELETE FROM Users WHERE Users_Id=:Users_Id');
                $stmt->bindValue('Users_Id', $d->Users_Id);
                $stmt->execute();
                $obrisaniid[]=$d->Users_Id;
            }
        }

        // tu nešto ne valja, dobije dobre ID ali ne obriše


        foreach ($obrisaniid as $o){
            $db=Db::getInstance();
            $stmt=$db->prepare('DELETE FROM Users_Memberships WHERE Users_Memberships_Users_Id=:Users_Memberships_Users_Id');
            $stmt->bindValue('Users_Memberships_Users_Id', $o);
            $stmt->execute();

            $stmt=$db->prepare('DELETE FROM Users_Memberships_Archive WHERE Users_Memberships_Users_Id=:Users_Memberships_Users_Id');
            $stmt->bindValue('Users_Memberships_Users_Id', $o);
            $stmt->execute();
        }
    }

    public function deletesales()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sales');
        $stmt->execute();
        $data=$stmt->fetchAll();

        foreach ($data as $d)
        {
            $random = rand(1,2);
            if ($random == 1){
                $stmt=$db->prepare('DELETE FROM Sales WHERE Sales_Id=:Sales_Id');
                $stmt->bindValue('Sales_Id', $d->Sales_Id);
                $stmt->execute();
            }
        }
    }

    public function deletesalesWarehouse()
    {
        $db=Db::getInstance();
        $stmt=$db->prepare('SELECT * FROM Sales_Warehouse');
        $stmt->execute();
        $data=$stmt->fetchAll();

        foreach ($data as $d)
        {
            $random = rand(1,2);
            if ($random == 1){
                $stmt=$db->prepare('DELETE FROM Sales_Warehouse WHERE Sales_Warehouse_Id=:Sales_Warehouse_Id');
                $stmt->bindValue('Sales_Warehouse_Id', $d->Sales_Warehouse_Id);
                $stmt->execute();
            }
        }
    }
     */
}