<?php

namespace App\Nova;

use App\Nova\Actions\BeneficiaryPdf;
use App\Nova\Actions\ImportBeneficiaries;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Records');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Record');
    }
    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel()
    {
        return __('Create Record');
    }
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
            Text::make(__('Name'),'name')->rules('required', 'string', 'max:255'),
            Text::make(__('Address'),'address')->hideFromIndex(),
            Text::make(__('Status'),'statuses'),
            BelongsTo::make(__('city'), 'city', 'App\Nova\City')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Text::make(__('Birthdate'),'birthdate'),
            Number::make(__('Telephone 1'),'Tel1'),
            Number::make(__('Telephone 2'),'Tel2')->hideFromIndex(),
            Number::make(__('Family Members'),'familyMembers'),
            BelongsTo::make(__('superviser'), 'superviser', 'App\Nova\Superviser')->showCreateRelationButton()->withoutTrashed()->filterable()->nullable(),
            Boolean::make(__('Active'),'active')->rules('required')->default(1)->onlyOnForms(),
            NovaSwitcher::make(__('Active'),'active')->filterable()->exceptOnForms(),
            File::make(__('file')),
            Textarea::make(__('note'),'note')->nullable(),
            HasMany::make('donation','donation', 'App\Nova\Donation')->nullable(),
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
