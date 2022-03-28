<?php

class MembershipController extends SecurityController
{
    public function allMemberships()
    {
        echo json_encode(Membership::allActiveMemberships());
    }
}