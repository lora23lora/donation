<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Zakat extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Zakat>
     */
    public static $model = \App\Models\Zakat::class;

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
            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->showCreateRelationButton()->withoutTrashed()->searchable()->filterable(),
            Number::make(__('Amount'),'amount'),
            Date::make(__('Date'),'date')->rules('required','date')->filterable(),
            Textarea::make(__('Note'),'note')->nullable(),


        ];
    }

}
