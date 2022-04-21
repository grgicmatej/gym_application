<?php

class StatisticsController extends SecurityController
{
    public function yearlyStats()
    {
        $this->adminCheck();
        echo json_encode(Statistics::yearlyStats());
    }

    public function yearlyStatsPreviousYear()
    {
        $this->adminCheck();
        echo json_encode(Statistics::yearlyStatsPreviousYear());
    }

    public function popularMemberships()
    {
        $this->adminCheck();
        echo json_encode(Statistics::popularMemberships());
    }

    public function ageOfUsers()
    {
        $this->adminCheck();
        echo json_encode(Statistics::ageOfUsers());
    }

    public function usersGender()
    {
        $this->adminCheck();
        echo json_encode(Statistics::usersGender());
    }

    public function usersStatus()
    {
        $this->adminCheck();
        echo json_encode(Statistics::usersStatus());
    }

    public function usersReference()
    {
        $this->adminCheck();
        echo json_encode(Statistics::usersReference());
    }
}