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
 * Prepare the resource for JSON serialization.
 *
 * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
 * @param  \Illuminate\Support\Collection  $fields
 * @return array
 */
public function serializeForIndex(NovaRequest $request, $fields = null)
{
    // Get proper response
    $serialized = parent::serializeForIndex($request, $fields);

    if ($request->lens && $request->lens == 'total_amount') {
        // If a lens is being viewed
        $serialized = array_merge($serialized, [
            'authorizedToView' => false,
            'authorizedToUpdate' => false,
            'authorizedToDelete' => false,
            'authorizedToRestore' => false,
            'authorizedToForceDelete' => false,
        ]);
    }

    return $serialized;
}
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
        return $request->withOrdering($request->withFilters(
            $query->select(self::columns())
                ->selectRaw('CONCAT(donations.name, "_", donations.city_id) as name_city, COUNT(*) AS Occurrences')
                ->groupBy('name_city', 'donations.name', 'donations.city_id')
                ->withCasts([
                    'amount' => 'float',
                ])
        ), fn ($query) => $query->orderBy('total', 'desc'));
    }

 /**
     * Get the columns that should be selected.
     *
     * @return array
     */
    protected static function columns()
    {
        return [
            'donations.name',
            'donations.city_id',
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
            // ID::make(Nova::__('ID'), 'id')->sortable(),
            Text::make('Name', 'name'),
            BelongsTo::make('city', 'city', 'App\Nova\City'),

            Number::make('Total', 'total', function ($value) {
                return '$'.number_format($value, 2);
            }),

            Number::make('Occurrences','Occurrences'),

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
