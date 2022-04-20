<?php


class StaffController extends SecurityController
{
    public function allStaffInfo()
    {
        $this->adminCheck();
        echo json_encode(Staff::allStaffData());
    }

    public function changeStaffPassword()
    {
        $this->employeeCheck();
        echo json_encode(Staff::newPasswordByAdmin());
    }

    public function changeActiveStatusStaff()
    {
        $this->adminCheck();
        echo json_encode(Staff::changeActiveStatus());
    }

    public function checkStaffMemberships()
    {
        $this->adminCheck();
        echo json_encode(Staff::checkStaffMemberships());
    }

    public function checkStaffUsername()
    {
        $this->employeeCheck();
        echo json_encode(Staff::checkStaffUsername());
    }

    public function dataChange()
    {
        $this->employeeCheck();
        Staff::userDataChange();
    }

    public function editStaff($id)
    {
        $this->employeeCheck();
        echo json_encode(Staff::editStaff($id));
    }

    public function newStaff()
    {
        $this->adminCheck();
        echo json_encode(Staff::newStaff());
    }

    public function passwordChecker()
    {
        $this->employeeCheck();
        echo json_encode(Staff::passwordChangeCheck());
    }

    public function passwordChange()
    {
        $this->employeeCheck();
        Staff::newPassword();
    }

    public function staffInfo($id = 0)
    {
        $this->employeeCheck();
        echo json_encode(Staff::staffData($id == 0 ? 0 : $id));
    }
}