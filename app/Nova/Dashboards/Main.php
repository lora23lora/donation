<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Balance;
use App\Nova\Metrics\CityMetric;
use App\Nova\Metrics\NewBeneficiary;
use App\Nova\Metrics\TotalAmount;
use App\Nova\Metrics\TotalExpense;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public function name()
    {
        return __('Main');
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new TotalAmount(),
            new TotalExpense(),
            new Balance(),
            new CityMetric(),
            new NewBeneficiary(),
            // new UsersPerDay()
        ];
    }
}
