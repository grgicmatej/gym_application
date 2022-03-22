<?php


class StaffController extends SecurityController
{
    public function changeActiveStatusStaff()
    {
        echo json_encode(Staff::changeActiveStatus());
    }

    public function passwordChecker()
    {
        echo json_encode(Staff::passwordChangeCheck());
    }

    public function passwordChange()
    {
        Staff::newPassword();
    }

    public function dataChange()
    {
        Staff::userDataChange();
    }

    public function staffInfo($id = 0)
    {
        echo json_encode(Staff::staffData($id));
    }

    public function allStaffInfo()
    {
        echo json_encode(Staff::allStaffData());
    }
}