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
            //Timers::checkStarTime();
            echo json_encode(true); // ovo je za početak timera, treba iskočiti widget sa live štopericom i sl.
        }else{ //end
            echo json_encode(false);
        }

    }

    public function checkStartedTime()
    {
        echo json_encode(Timers::checkStarTime());
    }
}