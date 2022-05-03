<?php


class TestController extends SecurityController
{
// Ovo je za ciscenje baze
/*
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
*/
}