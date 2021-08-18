<?php


class UserController
{
    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }
}