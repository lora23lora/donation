<?php

namespace App\Nova\Lenses;

use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class DonationStorageLens extends Lens
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
        return __("Total Item Donated");
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
        $query = $request->withFilters($query);

    // Apply your specific query
    $query->select('storage_item_id', 'storages.item_name', DB::raw('SUM(amount) as total_amount'))
          ->leftJoin('storages', 'storages.item_id', '=', 'donation_storage.storage_item_id')
          ->groupBy('storage_item_id', 'storages.item_name');

    // Apply ordering after filtering
    return $request->withOrdering($query);
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
            Text::make(__('Item Name'), 'item_name')->sortable(),
            Text::make(__('Total Amount'), 'total_amount'),
            Date::make(__('Date'), 'date')->filterable()->hideFromIndex(),

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
     * Get the filters available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'donation-storage-lens';
    }
}
