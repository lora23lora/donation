<?php

namespace App\Nova;

use App\Models\User;
use App\Nova\Filters\StatusFilter;
use App\Nova\Filters\SuperviserFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Contracts\FilterableField;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Donation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Donation>
     */
    public static $model = \App\Models\Donation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('name')->rules('required', 'string', 'max:255'),
            Text::make('address'),
            BelongsTo::make('city_id', 'city', 'App\Nova\City')->showCreateRelationButton()->withoutTrashed()->filterable(),
            Text::make('birthdate'),
            Number::make('Telephone1','Tel1'),
            Number::make('Telephone2','Tel2'),
            Number::make('amount'),
            BelongsTo::make('status_id', 'status', 'App\Nova\Status')->showCreateRelationButton()->withoutTrashed()->filterable(),
            Text::make(__('CreatedByUser'),'CreatedByUserId',
            function () {
                $userId = $this->user_id;
                $user = User::findOrFail($userId);
                return $user->name;
            })->onlyOnDetail(),
            Number::make('family Members','familyMembers'),
            BelongsTo::make('superviser_id', 'superviser', 'App\Nova\Superviser')->showCreateRelationButton()->withoutTrashed()->filterable(),
            Boolean::make('Active','active')->rules('required')->default(1)->filterable(),
            Textarea::make('note','note')->nullable(),
            Date::make('Date','date'),
            Hidden::make('user_id', 'user_id')->default(function ($request) {
                return $request->user()->id;
            }),
            File::make('file')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [


        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
