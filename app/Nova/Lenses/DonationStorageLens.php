<?php

namespace App\Nova\Lenses;

use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class DonationStorageLens extends Lens
{
    public static $search = [];

    public function name()
    {
        return __("Total Item Donated");
    }

    public static function query(LensRequest $request, $query)
    {
        $query = $request->withFilters($query);

        // Use distinct `storage_item_id` and sum the amount for each item
        $query->select(
            'donation_storage.storage_item_id',
            'storages.item_name',
            'storages.unit',
            DB::raw('SUM(donation_storage.amount) as total_amount')
        )
        ->leftJoin('storages', 'storages.item_id', '=', 'donation_storage.storage_item_id')
        ->groupBy('donation_storage.storage_item_id', 'storages.item_name', 'storages.unit');

        // Apply ordering after filtering
        return $request->withOrdering($query);
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__('Item Name'), 'item_name')->sortable(),
            Text::make(__('Unit'), 'unit')->sortable(),
            Text::make(__('Total Amount'), 'total_amount')->sortable(),
            Date::make(__('Date'), 'date')->filterable()->hideFromIndex(),
        ];
    }


    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    public function uriKey()
    {
        return 'donation-storage-lens';
    }
}
