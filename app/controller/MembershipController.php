<?php

class MembershipController extends SecurityController
{
    public function allMemberships()
    {
        $this->employeeCheck();
        echo json_encode(Membership::allMemberships());
    }

    public function allActiveMemberships()
    {
        $this->employeeCheck();
        echo json_encode(Membership::allActiveMemberships());
    }

    public function checkMembership()
    {
        $this->employeeCheck();
        echo json_encode(Membership::selectMembershipById());
    }

    public function changeActiveStatusMembership()
    {
        $this->employeeCheck();
        echo json_encode(Membership::changeActiveStatus());
    }

    public function deleteMembership()
    {
        $this->employeeCheck();
        Membership::deleteMembership();
    }

    public function editMembership($id)
    {
        $this->employeeCheck();
        echo json_encode(Membership::editMembership($id));
    }

    public function newMembership()
    {
        $this->employeeCheck();
        Membership::newMembeship();
    }
}