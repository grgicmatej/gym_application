<?php


class AditionalController extends SecurityController
{
    public function checkTimer()
    {
        echo json_encode(Timers::checkTimer());
    }

    public function manipulateTimer()
    {
        echo json_encode(Timers::manipulateTimer());
    }

    public function checkStartedTime()
    {
        echo json_encode(Timers::checkStartTime());
    }

    public function checkTotalTime()
    {
        echo json_encode(Timers::checkTotalTime());
    }

    public function checkSportsName()
    {
        echo json_encode(Sports::checkSportsName());
    }
}