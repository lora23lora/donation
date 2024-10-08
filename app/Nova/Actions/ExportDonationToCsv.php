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
        $lineItems = [];
        // foreach ($model->line_items as $line_item) {
        //     $storageItem = Storage::find($line_item['attributes']['items']);
        //     $itemName = $storageItem ? $storageItem->item_name : 'Unknown';
        //     $lineItems[] = " $itemName - Qty: {$line_item['attributes']['qty']},";
        // }
        return [
            $model->beneficiary->name,
            $model->beneficiary->city->city_name,
            $model->beneficiary->address,
            $model->beneficiary->birthdate,
            $model->beneficiary->familyMembers,
            $this->getStatusString($model->beneficiary->status),
            $model->amount,
            $model->beneficiary->superviser->name ?? 'N/A',
            $model->beneficiary->Tel1,
            $model->beneficiary->Tel2,
            implode("\n", $lineItems), // Join line items into a string
            $model->beneficiary->active,
            $model->note,
        ];
    }


    protected function getStatusString($status): string
    {
        if (is_array($status)) {
            return implode(', ', \App\Models\Status::whereIn('status_id', $status)->pluck('name')->toArray());
        }

        return \App\Models\Status::find($status)->name;
    }
}
