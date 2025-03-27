<?php

namespace App\Nova\Actions;

use App\Models\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportDonationToCsv extends DownloadExcel implements WithMapping, WithHeadings
{

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __("Export Donation To CSV");
    }
     /**
     * @return array
     */
    public function headings(): array
    {
    return [
        'name',
        'city',
        'address',
        'birthdate',
        'familyMembers',
        'status',
        'amount',
        'superviser',
        'Tel1',
        'Tel2',
        'items',
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
        $items = $model->storages->pluck('item_name')->join(', ');
        return [
            $model->beneficiary?->name ?? '',
            $model->beneficiary?->city?->city_name ?? '',
            $model->beneficiary?->address ?? '',
            $model->beneficiary?->birthdate ?? '',
            $model->beneficiary?->familyMembers ?? '',
            $this->getStatusString($model->beneficiary->status ?? ''),
            $model->amount ?? '',
            $model->superviser?->name ?? 'N/A',
            $model->beneficiary?->Tel1 ?? '',
            $model->beneficiary?->Tel2 ?? '',
            $items, // Join line items into a string
            $model->note ?? '',
        ];
    }


    protected function getStatusString($status): string
    {
        if (empty($status)) {
            return ''; // Return an empty string if status is null or empty
        }

        if (is_array($status)) {
            return implode(', ', \App\Models\Status::whereIn('status_id', $status)->pluck('name')->toArray());
        }

        return \App\Models\Status::find($status)?->name ?? '';
    }
}
