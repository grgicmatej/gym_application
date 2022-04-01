<?php

class MembershipController extends SecurityController
{
    public function allMemberships()
    {
        echo json_encode(Membership::allMemberships());
    }

    public function allActiveMemberships()
    {
        echo json_encode(Membership::allActiveMemberships());
    }

    public function checkMembership()
    {
        echo json_encode(Membership::selectMembershipById());
    }

    public function changeActiveStatusMembership()
    {
        echo json_encode(Membership::changeActiveStatus());
    }

    public function deleteMembership()
    {
        Membership::deleteMembership();
    }

    public function editMembership($id)
    {
        echo json_encode(Membership::editMembership($id));
    }

    public function newMembership()
    {
        Membership::newMembeship();
    }
}