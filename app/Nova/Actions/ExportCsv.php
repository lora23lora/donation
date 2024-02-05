<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportCsv extends DownloadExcel implements WithMapping, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
    return [
        'id',
        'name',
        'city',
        'address',
        'birthdate',
        'familyMembers',
        'status',
        'superviser',
        'Tel1',
        'Tel2',
        'active',
        'note',
        ];
    }

    /**
     * @param $order
     *
     * @return array
     */
    public function map($model): array
    {
        return [
           $model->getKey(),
            $model->name,
            $model->city->city_name,
            $model->address,
            $model->birthdate,
            $model->familyMembers,
            $this->getStatusString($model->status),
            $model->superviser->name,
            $model->Tel1,
            $model->Tel2,
            $model->active,
            $model->note,
        ];
    }

    protected function getStatusString($status): string
    {
        $statusArray = is_array($status) ? $status : json_decode($status);

        if (is_array($statusArray)) {
            return implode(', ', \App\Models\Status::whereIn('status_id', $statusArray)->pluck('name')->toArray());
        }

        return \App\Models\Status::find($statusArray)->name;
    }
}
