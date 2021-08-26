<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);
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