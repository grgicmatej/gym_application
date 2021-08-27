<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);
    }

    public function addNewUserMembership($id)
    {
        // ime članarine je u "usersMembershipsMembershipName"
        $data=Membership::Select_Membership();
        foreach ($data as $data){
            $Memberships_Price=$data->Memberships_Price;
            $Memberships_Duration=$data->Memberships_Duration;
            $Memberships_Id=$data->Memberships_Id;
        }
        User::New_User_Membership_Extension($Memberships_Price, $Memberships_Duration);

        $data=User::Last_User_Membership_Extension();
        foreach ($data as $data){
            $Users_Memberships_Id=$data->Users_Memberships_Id;
            $Users_Memberships_Membership_Name=$data->Users_Memberships_Membership_Name;
            $Users_Memberships_Price=$data->Users_Memberships_Price;
        }
        User::New_User_Membership_Extension_Archive($Memberships_Price, $Memberships_Duration, $Users_Memberships_Id, $Memberships_Id);
        Sales::New_Membership_Sale($Users_Memberships_Membership_Name, $Users_Memberships_Price);
        $Users_Id=Request::post('Users_Memberships_Users_Id');
        $data=User::View_User_Data($Users_Id);
        foreach ($data as $data){
            $Users_Email=$data->Users_Email;
        }
        Sender::Delete_Recipient($Users_Id);
        Sender::Add_New_Recipient($Users_Email, $Users_Id);
        header( 'Location:'.App::config('url').'User/All_Users/');
    }

    public function allMemberships()
    {
        echo json_encode(Membership::allActiveMemberships());
    }

    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }
}