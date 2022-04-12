<?php

class FinancesController extends SecurityController
{
    public function yearlyStatsFinance()
    {
        echo json_encode(Finance::yearlyStatsFinances());
    }

    public function yearlyStatsPreviousYearFinance()
    {
        echo json_encode(Finance::yearlyStatsPreviousYearFinances());
    }
}