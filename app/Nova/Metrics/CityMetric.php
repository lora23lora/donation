<?php

namespace App\Nova\Metrics;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Donation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class CityMetric extends Partition
{

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __("City");
    }
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Beneficiary::class, 'city_id')->label(function ($value) {
            $city = City::find($value); // Assuming City model has the name attribute
            return $city ? $city->city_name : 'Unknown';
        });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'city-metric';
    }
}
