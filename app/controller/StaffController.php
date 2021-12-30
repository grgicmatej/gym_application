<?php


class StaffController extends SecurityController
{
    public function passwordChecker()
    {
        if (Staff::passwordChangeCheck()){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    public function passwordChange()
    {
        Staff::newPassword();
    }

    public function dataChange()
    {
        Staff::userDataChange();
    }
}