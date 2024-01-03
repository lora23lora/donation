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
        // Check if the logged-in user is an admin
        if ($request->user()->name === 'admin') {
            return $query; // Admin can see all donations
        } else {
            return $query->where('approved', true); // Regular user can only see approved donations
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
        return [
            ID::make()->sortable(),
            Text::make('Name','name')->rules('required', 'string', 'max:255'),
            Text::make('address','address')->hideFromIndex(),
            Text::make('Status','status'),
            BelongsTo::make('city', 'city', 'App\Nova\City')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Text::make('birthdate'),
            Number::make('Telephone1','Tel1'),
            Number::make('Telephone2','Tel2')->hideFromIndex(),
            // Number::make('amount')->onlyOnForms(),
            Number::make('amount')->canSee(function($request){
                return $request->user()->name === 'admin';
            }),
            Flexible::make('line_items','line_items')
            ->addLayout('Simple content section', 'wysiwyg', [
                Select::make('Items')
                ->options(Storage::pluck('item_name', 'item_id'))
                ->displayUsingLabels(),
                Number::make('qty','qty'),
                Number::make('price','price'),
            ]),
            Number::make('family Members','familyMembers'),
            BelongsTo::make('superviser', 'superviser', 'App\Nova\Superviser')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Boolean::make('Active','active')->rules('required')->default(1)->onlyOnForms(),
            NovaSwitcher::make('Active','active')->filterable()->exceptOnForms(),
            Boolean::make('Approved','approved')->filterable()->canSee(function($request){
                return $request->user()->name === 'admin';
            }),
            Textarea::make('note','note')->nullable(),
            Date::make('Date','date')->hideFromIndex(),
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
