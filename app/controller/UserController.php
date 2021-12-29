<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        User::newArrival($id);
    }

    public function addNewUserMembership($id)
    {
        if (Request::post('usersMembershipsMembershipName') == "disabled"){
            echo json_encode(false);
        }else{
            User::newUserMembershipExtension(Membership::selectMembership(), $id);
            User::lastUserMembershipExtension();
            User::newUserMembershipExtensionArchive(User::lastUserMembershipExtension(), Membership::selectMembership(), $id);

            Sale::newMembershipSale(Membership::selectMembership());

            Sender::deleteRecipient($id);
            Sender::addNewRecipient(User::viewUserEmail($id), $id, Membership::membershipEndDate(Membership::selectMembership()));
            echo json_encode(true);
        }
    }

    public function checkUsersId()
    {
        if (!User::checkUsersId()) {
            echo json_encode(false);
        } else{
            echo json_encode(true);
        }
    }

    public function addNewUser()
    {
        Upload::uploadPhoto();
        User::newUser(Upload::getFileName());
        User::addUserGymRegistration();
        User::newUserFirstMembershipExtension();
        echo json_encode(true);
    }

    public function allMemberships()
    {
        echo json_encode(Membership::allActiveMemberships());
    }

    public function viewUser($id)
    {
        echo json_encode(User::essentialUserData($id));
    }

    public function userDataSearch()
    {
        User::allUsersSearch();
    }
}