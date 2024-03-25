<?php

namespace App\Nova\Lenses;

use App\Models\Storage;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class ExpenseReport extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        // Filter out records where 'line_items' is not an empty array
    return $request->withOrdering($request->withFilters(
        $query->whereNotNull('line_items')
              ->where('line_items', '!=', '[]') // Assuming 'line_items' is stored as JSON
    ));
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
            Text::make('Items', function () {
                return $this->getItems();
            })->sortable(),

            Date::make('date','date')->filterable()
        ];
    }
    public function getItems()
    {
        $unique = [];

        foreach ($this->resource->line_items as $line_item) {
            // Check if line_item has 'attributes' key and is not an empty array
            if (isset($line_item['attributes']) && !empty($line_item['attributes'])) {
                // Assuming you have a Storage model with item_id and item_name attributes
                $item = Storage::find($line_item['attributes']['items']);

                if ($item) {
                    $itemName = $item->item_name;
                    if (!in_array($itemName, $unique)) {
                        $unique[] = $itemName;
                    }
                }
            }
        }

        return $unique;
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
        return 'expense-report';
    }
}
