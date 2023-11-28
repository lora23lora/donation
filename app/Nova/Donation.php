<?php

namespace App\Nova;

use App\Models\User;
use App\Nova\Actions\ExportToPdf;
use Laravel\Nova\Actions\ExportAsCsv;
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
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [

            // $url = route('purchase-pdf', ['models' => $models->pluck('PurchaseId')->implode(',')]);

            // return Action::redirect($url);

            // Route::get('/purchase-pdf', function () {

//     $modelIds = request()->query('models');
//     $models = Purchase::whereIn('PurchaseId', explode(',', $modelIds))->get();

//     $pdf = PDF::loadView('pdf.purchase', compact('models'));

//     return $pdf->stream('document.pdf');

// })->name('purchase-pdf');

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
                    'status' => $model->status->name,
                    'superviser' => $model->superviser->name,
                    'telephone1' => $model->Tel1,
                    'telephone2' => $model->Tel2,
                    'note' => $model->Tel2,
                    'active' => $model->active,
                    'date' => $model->date,
                ];
            }),
            new ExportToPdf
        ];
    }
}
