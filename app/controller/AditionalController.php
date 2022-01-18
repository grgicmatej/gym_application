<?php


class AditionalController extends SecurityController
{
    public function checkTimer()
    {
        echo json_encode(Timers::checkTimer());
    }

    public function manipulateTimer()
    {
        if (Timers::checkTimer()){ //start
            Timers::startTimer(Timers::checkPrice()->Sport_Settings_Price);
            echo json_encode(true);
        }else{ //end
            Timers::endTimer();
            echo json_encode(false);
        }
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