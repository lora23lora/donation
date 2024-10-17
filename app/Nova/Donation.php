<?php

namespace App\Nova;

use App\Nova\Actions\ExportDonationToCsv;
use App\Nova\Actions\ExportToPdf;
use App\Nova\Lenses\CityWithMostBeneficiary;
use App\Nova\Lenses\ExpenseReport;
use App\Nova\Lenses\TotalAmount;
use App\Nova\Metrics\Balance;
use App\Nova\Metrics\TotalExpense;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Expenses');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Expense');
    }

    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel()
    {
        return __('Create Expense');
    }

    /**
     * Get the text for the update resource button.
     *
     * @return string|null
     */
    public static function updateButtonLabel()
    {
        return __('Update Expense');
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','amount'
    ];

    public static function indexQuery(NovaRequest $request, $query)
{
    if ($request->user()->admin) {
        // If the user is an admin, return all records (both approved and unapproved)
        return $query;
    } else {
        // If the user is not an admin, only return approved records
        return $query->where('approved', true);
    }
}



    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        // $availableItems = Storage::where('qty', '>', 0)->pluck('item_name', 'item_id');

        return [
            ID::make(__('ID'),'id')->sortable(),
            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->showCreateRelationButton()->withoutTrashed()->searchable(),

            Number::make(__('Amount'),'amount')->onlyOnForms(),
            Number::make(__('Amount'),'amount')->exceptOnForms()->displayUsing(function ($value) {
                return number_format($value, 0, '.', ',');
            }),
            File::make('file')->rules('nullable'),
            Boolean::make(__('Approved'),'approved')->filterable()->canSee(function($request){
                return $request->user()->admin;
            })->filterable(),
            Date::make('Date','date')->nullable(),

            // Date::make(__('Date'),'date')->rules('required','date')->filterable(),
            BelongsToMany::make('Storage', 'storages', 'App\Nova\Storage')->fields(function ($request, $relatedModel) {
                return [
                    Date::make('Date','date')->rules('required','date'),
                    Number::make('Price','price')->nullable(),
                    Number::make('Amount','amount')->rules('required','numeric'),
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
        return [
            new TotalExpense(),
            new Balance(),
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
        // Check if the current URL contains 'lens'
        if (strpos(url()->current(), 'lens') !== false) {
            return []; // Return an empty array to remove actions on the lens
        }

        // Return actions for the Donation resource
        return [
            new ExportToPdf,
            new ExportDonationToCsv
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
        return [

            new TotalAmount(),
            new CityWithMostBeneficiary(),
            new ExpenseReport()
        ];
    }
}
