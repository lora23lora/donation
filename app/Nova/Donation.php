<?php

namespace App\Nova;

use App\Models\Storage;
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
            ID::make()->sortable(),
            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->display(function ($donation) {
                return __('Id:') . ' '. $donation->id . ' - ' . __('Name:'). ' ' . $donation->name . ' - ' . __('Statuses:'). ' ' . $donation->statuses . ' - ' . __('familyMembers:'). ' ' . $donation->familyMembers . ' - ' . __('Telephone 1:'). ' ' . $donation->Tel1 . ' - ' . __('City:'). ' ' . $donation->city->city_name;
            })->showCreateRelationButton()->withoutTrashed()->onlyOnForms()->searchable(),

            BelongsTo::make(__('beneficiary'),'beneficiary','App\Nova\Beneficiary')->onlyOnIndex(),

            Number::make('amount')->canSee(function($request){
                return $request->user()->name === 'admin';
            })->onlyOnForms(),
            Number::make('amount')->exceptOnForms(),
            Flexible::make('line_items','line_items')
            ->addLayout('Simple content section', 'wysiwyg', [
                Select::make('Items')
                ->options($availableItems)
                ->displayUsingLabels(),
            Number::make('qty', 'qty'),
            ]),

            Boolean::make('Approved','approved')->filterable()->canSee(function($request){
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
        return [
            ExportAsCsv::make()->nameable()->withFormat(function ($model){
                return [
                    'id' => $model->getKey(),
                    'name' => $model->beneficiary->name,
                    'city' => $model->beneficiary->city->city_name,
                    'address' => $model->beneficiary->address,
                    'birthdate' => $model->beneficiary->birthdate,
                    'familyMembers' => $model->beneficiary->familyMembers,
                    'statuses' => $model->beneficiary->statuses,
                    'superviser' => $model->beneficiary->superviser->name,
                    'Tel1' => $model->beneficiary->Tel1,
                    'Tel2' => $model->beneficiary->Tel2,
                    'active' => $model->beneficiary->active,
                    'amount' => $model->amount,
                    'note' => $model->beneficiary->note,
                    'item' => $model->line_items,
                ];
            }),
            new ExportToPdf,
            new Actions\ImportUsers

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
