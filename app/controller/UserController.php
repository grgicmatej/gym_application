<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        var_dump($_SESSION["Gym_Id"]);
        //User::newArrival($id);

        //die();
         //   header( 'Location:'.App::config('url').'Dashboard/Dashboard/?m=1');
    }

    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }
}