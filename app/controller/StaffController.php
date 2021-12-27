<?php


class StaffController extends SecurityController
{
    public function passwordChange()
    {
        if (Staff::passwordChangeCheck()){
            Staff::newPassword();
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    public function dataChange()
    {
        if (Staff::userDataChange()){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }
}