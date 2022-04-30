<?php


class UserController extends SecurityController
{
    public function addUserArrival($id)
    {
        
        User::newArrival($id);
    }

    public function addNewUserMembership($id)
    {
        
        echo json_encode(User::addNewUserMembership($id));
    }

    public function addNewUser()
    {
        
        if (!User::checkUsersId() && Request::post('probniTrening') != 1){
            echo json_encode(false);
        }else{
            Upload::uploadPhoto();
            User::newUser(Upload::getFileName(), Request::post('probniTrening') == 1 ? ('probno-'.time()) : null);
            User::addUserGymRegistration(Request::post('probniTrening') == 1 ? ('probno-'.time()) : null);
            User::newUserFirstMembershipExtension(Request::post('probniTrening') == 1 ? ('probno-'.time()) : null);
            echo json_encode(true);
        }
    }

    public function checkUsersId()
    {
        
        echo json_encode(User::checkUsersId());
    }

    public function checkUserMemberships()
    {
        
        echo json_encode(User::checkUserMemberships());
    }

    public function checkPausedMembership()
    {
        
        echo json_encode(User::checkPausedMembership());
    }

    public function editUser($id)
    {
        
        echo json_encode(User::editUserPrepare($id));
    }

    public function editMembershipUser($id)
    {
        
        User::editMembershipUser($id);
    }

    public function pauseMembership()
    {
        
        echo json_encode(User::pauseUser());
    }

    public function userDataSearch()
    {
        
        echo json_encode(User::allUsersSearch());
    }

    public function viewUser($id)
    {
        
        echo json_encode(User::essentialUserData($id));
    }
}