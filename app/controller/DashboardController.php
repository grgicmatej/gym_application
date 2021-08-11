<?php


class DashboardController extends SecurityController
{
    public function Dashboard()
    {
        // temp
        $db=Db::getInstance();
        $stmt=$db->prepare('select * from Staff where Staff_Id=1');
        $stmt->execute();
        $user=$stmt->fetch();

        Session::getInstance()->login($user);

        echo Session::getInstance()->getUser()->Staff_Username;


        $cookie_name="Staff_Id";
        $cookie_value=1;
        setcookie($cookie_name, $cookie_value, time() + (43200), "/");

        $cookie_name="Staff_Logged_In";
        $cookie_value=1;
        setcookie($cookie_name, $cookie_value, time() + (43200), "/");

        $cookie_name="Staff_Admin_Status";
        $cookie_value=4;
        setcookie($cookie_name, $cookie_value, time() + (43200), "/");
        // kraj temp

        $this->Employee_Check();
        Membership::Time_Update();
        if (isset($_COOKIE['Gym_Id'])){
            $Gym_Id=$_COOKIE['Gym_Id'];
        }else{
            $Gym_Id=0;
        }

        $data=Dashboard::checkGymData($Gym_Id);
        foreach ($data as $data){
            $Gym_Name=$data->Gym_Name;
        }
        if (empty($Gym_Name)){
            $Gym_Name='';
        }

        $tempdata=User::allUsers();
        $array=[];
        foreach ($tempdata as $data){
            if (!in_array($Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id, $array)){
                array_push($array, $Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id);
            }else{
                continue;
            }
        }
        $All_Users=count($array);

        $tempdata=User::allActiveUsers();
        $array=[];
        foreach ($tempdata as $data){
            if (!in_array($Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id, $array)){
                array_push($array, $Users_Memberships_Users_Id = $data->Users_Memberships_Users_Id);
            }else{
                continue;
            }
        }
        $Active_Users=count($array);

        $Inactive_Users=$All_Users-$Active_Users;


        $view=New View();
        $view->render('index',
            [
                'message'               =>'',
                'gymdata'               => Dashboard::gymData(),
                'Gym_Name'              => $Gym_Name,
                'Userdata'              => User::allUsers(),
                #'Notes_Number'          => Notes::Number_Note(),
                'All_Users_Count'       => $All_Users,
                'Active_Users_Count'    => $Active_Users,
                'Inactive_Users_Count'  => $Inactive_Users,
                #'Monthly_Income'        => Statistics::Monthly_Income()

            ]);

    }
}