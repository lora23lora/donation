<?php

namespace App\Nova;

use App\Models\Storage;
use App\Nova\Actions\ExportToPdf;
use App\Nova\Lenses\CityWithMostBeneficiary;
use App\Nova\Lenses\TotalAmount;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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
        'id', 'name', 'address' , 'birthdate','Tel1','Tel2','amount','familyMembers'
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
                return __('Id:') . ' '. $donation->id . ' - ' . __('Name:'). ' ' . $donation->name . ' - ' . __('Statuses:'). ' ' . $donation->statuses . ' - ' . __('familyMembers:'). ' ' . $donation->familyMembers . ' - ' . __('Telephone 1:'). ' ' . $donation->Tel1;
            })->showCreateRelationButton()->withoutTrashed()->onlyOnForms()->searchable(),

            Number::make('amount')->canSee(function($request){
                return $request->user()->name === 'admin';
            }),
            Flexible::make('line_items','line_items')
            ->addLayout('Simple content section', 'wysiwyg', [
                Select::make('Items')
                ->options($availableItems)
                ->displayUsingLabels(),
            Number::make('qty', 'qty'),
            ]),

            Boolean::make('Approved','approved')->filterable()->canSee(function($request){
                return $request->user()->name === 'admin';
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
                    'name' => $model->name,
                    'address' => $model->address,
                    'family Members' => $model->familyMembers,
                    'city' => $model->city->city_name,
                    'birthdate' => $model->birthdate,
                    'amount' => $model->amount,
                    'status' => $model->status,
                    'superviser' => $model->superviser->name,
                    'telephone1' => $model->Tel1,
                    'telephone2' => $model->Tel2,
                    'note' => $model->Tel2,
                    'active' => $model->active,
                    'date' => $model->date,
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
