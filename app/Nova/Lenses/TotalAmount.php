<?php

namespace App\Nova\Lenses;

use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class TotalAmount extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __("Record's Total Expense");
    }
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
                ->join('beneficiaries', 'donations.beneficiary_id', '=', 'beneficiaries.id')
                ->selectRaw('CONCAT(beneficiaries.name) as name,CONCAT(beneficiaries.id) as beneficiaries_id, COUNT(*) AS Occurrences')
                ->groupBy('name', 'beneficiaries_id', 'beneficiaries.city_id')
                ->withCasts([
                    'amount' => 'float',
                ])
        ), fn ($query) => $query->orderBy('total', 'desc'));
    }

    protected static function columns()
    {
        return [
            'beneficiaries.name',
            'beneficiaries.city_id',
            DB::raw('sum(donations.amount) as total'),
        ];
    }
    /**
     * Get the fields available to the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('beneficiaries_id'),'beneficiaries_id'),
            Text::make(__('Name'),'name')->onlyOnIndex(),

            // Text::make('City', 'city', 'App\Nova\City'),

            Number::make(__('Total'), 'total', function ($value) {
                return '$'.number_format($value, 2);
            }),

            Number::make(__('Occurrences'),'Occurrences'),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

     /**
     * Get the actions available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }


    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'total-amount';
    }



}
