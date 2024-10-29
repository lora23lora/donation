<?php

namespace App\Nova;

use App\Nova\Actions\ExportItemToPdf;
use App\Nova\Lenses\ItemReport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Storage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Storage>
     */
    public static $model = \App\Models\Storage::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'item_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'item_id', 'item_name'
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Items');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Item');
    }

    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel()
    {
        return __('Create Item');
    }

    /**
     * Get the text for the update resource button.
     *
     * @return string|null
     */
    public static function updateButtonLabel()
    {
        return __('Update Item');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('item_id'),'item_id')->sortable(),
            Text::make(__('Item Name'),'item_name'),
            Text::make(__('Unit'),'unit')->rules('required','string','max:255'),
            BelongsTo::make('Item Category','category','App\Nova\ItemCategory')->showCreateRelationButton(),
            Textarea::make(__('Note'),'note'),
            BelongsToMany::make('Donation', 'donations', 'App\Nova\Donation')->fields(function ($request, $relatedModel) {
                return [
                    Hidden::make('Date', 'date')
                    ->default(now()->format('Y-m-d'))
                    ->rules('required', 'date'),
                    Number::make('Price','price')->nullable(),
                    Number::make('Amount','amount'),
                ];
            }),

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
        return [];
    }
/**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [

            new ItemReport()
        ];
    }


    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {

        return [
            new ExportItemToPdf,
        ];
    }
}
