<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);

    }

    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }
}