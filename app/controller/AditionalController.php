<?php


class AditionalController extends SecurityController
{
    public function checkTimer()
    {
        $this->employeeCheck();
        echo json_encode(Timers::checkTimer());
    }

    public function manipulateTimer()
    {
        $this->employeeCheck();
        echo json_encode(Timers::manipulateTimer());
    }

    public function checkStartedTime()
    {
        $this->employeeCheck();
        echo json_encode(Timers::checkStartTime());
    }

    public function checkTotalTime()
    {
        $this->employeeCheck();
        echo json_encode(Timers::checkTotalTime());
    }

    public function checkSportsName()
    {
        $this->employeeCheck();
        echo json_encode(Sports::checkSportsName());
    }
}