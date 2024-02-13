<?php

namespace App\Nova;

use App\Models\Storage;
use App\Nova\Actions\ExportDonationToCsv;
use App\Nova\Actions\ExportToPdf;
use App\Nova\Lenses\CityWithMostBeneficiary;
use App\Nova\Lenses\TotalAmount;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

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
    public static $title = 'name';

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
        if ($request->user()->name === 'admin') {
            return $query;
        } else {
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
        $availableItems = Storage::where('qty', '>', 0)->pluck('item_name', 'item_id');

        return [
            ID::make(__('ID'),'id')->sortable(),
            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->display(function ($beneficiary) {
                return __('Id:') . ' '. $beneficiary->id . ' - ' . __('Name:'). ' ' . $beneficiary->name  . ' - ' . __('familyMembers:'). ' ' . $beneficiary->familyMembers . ' - ' . __('Telephone 1:'). ' ' . $beneficiary->Tel1;
            })->showCreateRelationButton()->withoutTrashed()->onlyOnForms()->searchable(),

            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->onlyOnIndex(),

            Number::make(__('Amount'),'amount')->canSee(function($request){
                return $request->user()->name === 'admin';
            })->onlyOnForms(),
            Number::make(__('Amount'),'amount')->exceptOnForms(),
            Flexible::make(__('Items'),'line_items')
            ->addLayout(__('section'), 'wysiwyg', [
                Select::make(__('Items'),'items')
                ->options($availableItems)
                ->displayUsingLabels(),
            Number::make(__('qty'), 'qty'),
            ]),

            Boolean::make(__('Approved'),'approved')->filterable()->canSee(function($request){
                return $request->user()->name === 'admin';
            })->filterable(),

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
            new CityWithMostBeneficiary()
        ];
    }
}
