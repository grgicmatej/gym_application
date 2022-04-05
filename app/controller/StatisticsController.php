<?php

class StatisticsController extends SecurityController
{
    public function yearlyStats()
    {
        echo json_encode(Statistics::yearlyStats());
    }
}