<?php


class StaffController extends SecurityController
{
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

    public function staffInfo()
    {
        echo json_encode(Staff::staffData());
    }

    public function allStaffInfo()
    {
        echo json_encode(Staff::allStaffData());
    }
}