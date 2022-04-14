<?php

class StatisticsController extends SecurityController
{
    public function yearlyStats()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::yearlyStats());
    }

    public function yearlyStatsPreviousYear()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::yearlyStatsPreviousYear());
    }

    public function popularMemberships()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::popularMemberships());
    }

    public function ageOfUsers()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::ageOfUsers());
    }

    public function usersGender()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::usersGender());
    }

    public function usersStatus()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::usersStatus());
    }

    public function usersReference()
    {
        $this->employeeCheck();
        echo json_encode(Statistics::usersReference());
    }
}