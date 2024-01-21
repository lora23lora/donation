<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Superviser;
use Maatwebsite\Excel\Concerns\ToModel;

class BeneficiariesImport implements ToModel
{

    private $firstRow = true;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if ($this->firstRow) {
            $this->firstRow = false;
            return null;
        }

        $cityName = $row['1'];
        $superviserName = $row['6'];


        $city = City::where('city_name', $cityName)->first();
        $superviser = Superviser::where('name', $superviserName)->first();

        if ($city) {
            $data['city_id'] = $city->city_id;
        }

        if ($superviser) {
            $data['superviser_id'] = $superviser->superviser_id;
        }

        return new Beneficiary([
            'name' => $row['0'],
            'address' => $row['2'],
            'birthdate' => $row['3'],
            'familyMembers' => $row['4'],
            'statuses' => $row['5'],
            'Tel1' => $row['7'],
            'Tel2' => $row['8'],
            'active' => $row['9'],
            'note' => $row['10'],
        ]);
    }
}
