<?php

class FinancesController extends SecurityController
{
    public function yearlyStatsFinance()
    {
        $this->adminCheck();
        echo json_encode(Finance::yearlyStatsFinances());
    }

    public function yearlyStatsPreviousYearFinance()
    {
        $this->adminCheck();
        echo json_encode(Finance::yearlyStatsPreviousYearFinances());
    }

    public function yearlyIncome()
    {
        $this->adminCheck();
        echo json_encode(Finance::yearlyIncome());
    }

    public function monthlyIncome()
    {
        $this->adminCheck();
        echo json_encode(Finance::monthlyIncome());
    }

    public function yesterdayIncome()
    {
        $this->adminCheck();
        echo json_encode(Finance::yesterdayIncome());
    }

    public function dailyIncome()
    {
        $this->adminCheck();
        echo json_encode(Finance::dailyIncome());
    }

    public function yearlyIncomeMemberships()
    {
        $this->adminCheck();
        echo json_encode(Finance::yearlyIncomeMemberships());
    }

    public function yearlyIncomeOther()
    {
        $this->adminCheck();
        echo json_encode(Finance::yearlyIncomeOther());
    }

    public function incomeOnSpecificDate()
    {
        $this->adminCheck();
        echo json_encode(Finance::incomeOnSpecificDate());
    }
}