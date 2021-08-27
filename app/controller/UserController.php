<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);
    }

    public function addNewUserMembership($id)
    {
        User::newUserMembershipExtension(Membership::selectMembership(), $id);
        User::lastUserMembershipExtension(); // ima $Users_Memberships_Price, users_memberships_id, Users_Memberships_Membership_Name
        User::newUserMembershipExtensionArchive(User::lastUserMembershipExtension(), Membership::selectMembership(), $id);

        Sale::newMembershipSale(Membership::selectMembership());

        Sender::deleteRecipient($id);
        Sender::addNewRecipient(User::viewUserEmail($id), $id, Membership::membershipEndDate(Membership::selectMembership()));

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