<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Status;
use App\Models\Superviser;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BeneficiariesImport implements ToModel, WithStartRow
{
    use Importable;

    /**
     * Get the displayable name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('Import Record');
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cityName = $row['1'];
        $statusNames = explode(', ', $row['5']);
        $superviserName = $row['6'];

        $city = City::where('city_name', $cityName)->first();
        $superviser = Superviser::where('name', $superviserName)->first();

        $statusIds = [];

        foreach ($statusNames as $statusName) {
            $status = Status::where('name', $statusName)->first();

            if ($status) {
                $statusIds[] = (string) $status->status_id;
            }
        }

        $beneficiary = new Beneficiary([
            'name' => $row['0'],
            'address' => $row['2'],
            'birthdate' => $row['3'],
            'familyMembers' => $row['4'],
            'Tel1' => $row['7'],
            'Tel2' => $row['8'],
            'active' => $row['9'],
            'note' => $row['10'],
        ]);

        $beneficiary->city_id = $city ? $city->city_id : null;
        $beneficiary->status = $statusIds;

        $beneficiary->superviser_id = $superviser ? $superviser->superviser_id : null;

        return $beneficiary;
    }




    public function startRow():int{
        return 2;
    }
}
