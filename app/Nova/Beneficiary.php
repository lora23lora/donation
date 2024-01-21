<?php

namespace App\Nova;

use App\Nova\Actions\BeneficiaryPdf;
use App\Nova\Actions\ImportBeneficiaries;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Beneficiary extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Beneficiary>
     */
    public static $model = \App\Models\Beneficiary::class;

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
        'id', 'name', 'birthdate', 'address','Tel1', 'Tel2', 'familyMembers', 'statuses'
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
            Text::make('Name','name')->rules('required', 'string', 'max:255'),
            Text::make('address','address')->hideFromIndex(),
            Text::make('Status','statuses'),
            BelongsTo::make('city', 'city', 'App\Nova\City')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Text::make('birthdate'),
            Number::make('Telephone 1','Tel1'),
            Number::make('Telephone 2','Tel2')->hideFromIndex(),
            Number::make('family Members','familyMembers'),
            BelongsTo::make('superviser', 'superviser', 'App\Nova\Superviser')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Boolean::make('Active','active')->rules('required')->default(1)->onlyOnForms(),
            NovaSwitcher::make('Active','active')->filterable()->exceptOnForms(),
            File::make('file'),
            Textarea::make('note','note')->nullable()
        ];
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
                    'city' => $model->city->city_name,
                    'address' => $model->address,
                    'birthdate' => $model->birthdate,
                    'familyMembers' => $model->familyMembers,
                    'statuses' => $model->statuses,
                    'superviser' => $model->superviser->name,
                    'Tel1' => $model->Tel1,
                    'Tel2' => $model->Tel2,
                    'active' => $model->active,
                    'note' => $model->note,
                ];
            }),
            new BeneficiaryPdf,
            new ImportBeneficiaries
        ];
    }
}
