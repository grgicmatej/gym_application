<?php

class StatisticsController extends SecurityController
{
    public function yearlyStats()
    {
        echo json_encode(Statistics::yearlyStats());
    }

    public function yearlyStatsPreviousYear()
    {
        echo json_encode(Statistics::yearlyStatsPreviousYear());
    }

    public function popularMemberships()
    {
        echo json_encode(Statistics::popularMemberships());
    }

    public function ageOfUsers()
    {
        echo json_encode(Statistics::ageOfUsers());
    }

    public function usersGender()
    {
        echo json_encode(Statistics::usersGender());
    }

    public function usersStatus()
    {
        echo json_encode(Statistics::usersStatus());
    }

    public function usersReference()
    {
        echo json_encode(Statistics::usersReference());
    }
}