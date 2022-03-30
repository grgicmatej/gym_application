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
}