<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);
        //header( 'Location:'.App::config('url').'Dashboard/Dashboard/?m=1');
    }

    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }
}