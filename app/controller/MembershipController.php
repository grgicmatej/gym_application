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
        $this->adminCheck();
        echo json_encode(Membership::changeActiveStatus());
    }

    public function deleteMembership()
    {
        $this->adminCheck();
        Membership::deleteMembership();
    }

    public function editMembership($id)
    {
        $this->adminCheck();
        echo json_encode(Membership::editMembership($id));
    }

    public function newMembership()
    {
        $this->adminCheck();
        Membership::newMembeship();
    }
}