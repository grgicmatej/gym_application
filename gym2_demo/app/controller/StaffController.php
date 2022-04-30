<?php


class StaffController extends SecurityController
{
    public function allStaffInfo()
    {
        
        echo json_encode(Staff::allStaffData());
    }

    public function changeStaffPassword()
    {
        
        echo json_encode(Staff::newPasswordByAdmin());
    }

    public function changeActiveStatusStaff()
    {
        
        echo json_encode(Staff::changeActiveStatus());
    }

    public function checkStaffMemberships()
    {
        
        echo json_encode(Staff::checkStaffMemberships());
    }

    public function checkStaffUsername()
    {
        
        echo json_encode(Staff::checkStaffUsername());
    }

    public function dataChange()
    {
        
        Staff::userDataChange();
    }

    public function editStaff($id)
    {
        
        echo json_encode(Staff::editStaff($id));
    }

    public function newStaff()
    {
        
        echo json_encode(Staff::newStaff());
    }

    public function passwordChecker()
    {
        
        echo json_encode(Staff::passwordChangeCheck());
    }

    public function passwordChange()
    {
        
        Staff::newPassword();
    }

    public function staffInfo($id = 0)
    {
        
        echo json_encode(Staff::staffData($id == 0 ? 0 : $id));
    }
}