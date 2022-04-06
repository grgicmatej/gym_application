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
}