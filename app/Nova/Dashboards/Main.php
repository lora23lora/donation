<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\CityMetric;
use App\Nova\Metrics\NewBeneficiary;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new CityMetric(),
            new NewBeneficiary(),
            new UsersPerDay()
        ];
    }
}
