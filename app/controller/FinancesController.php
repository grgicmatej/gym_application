<?php

class FinancesController extends SecurityController
{
    public function yearlyStatsFinance()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yearlyStatsFinances());
    }

    public function yearlyStatsPreviousYearFinance()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yearlyStatsPreviousYearFinances());
    }

    public function yearlyIncome()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yearlyIncome());
    }

    public function monthlyIncome()
    {
        $this->employeeCheck();
        echo json_encode(Finance::monthlyIncome());
    }

    public function yesterdayIncome()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yesterdayIncome());
    }

    public function dailyIncome()
    {
        $this->employeeCheck();
        echo json_encode(Finance::dailyIncome());
    }

    public function yearlyIncomeMemberships()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yearlyIncomeMemberships());
    }

    public function yearlyIncomeOther()
    {
        $this->employeeCheck();
        echo json_encode(Finance::yearlyIncomeOther());
    }

    public function incomeOnSpecificDate()
    {
        $this->employeeCheck();
        echo json_encode(Finance::incomeOnSpecificDate());
    }
}