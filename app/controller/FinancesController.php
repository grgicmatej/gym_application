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

    public function yearlyIncome()
    {
        echo json_encode(Finance::yearlyIncome());
    }

    public function monthlyIncome()
    {
        echo json_encode(Finance::monthlyIncome());
    }

    public function dailyIncome()
    {
        echo json_encode(Finance::dailyIncome());
    }

    public function yearlyIncomeMemberships()
    {
        echo json_encode(Finance::yearlyIncomeMemberships());
    }
}