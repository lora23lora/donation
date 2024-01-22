<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Superviser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BeneficiariesImport implements ToModel, WithStartRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {


        $cityName = $row['1'];
        $superviserName = $row['6'];


        $city = City::where('city_name', $cityName)->first();
        $superviser = Superviser::where('name', $superviserName)->first();



        $beneficiary = new Beneficiary([
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
        
        $beneficiary->city_id = $city ? $city->city_id : null;

        // Check if the supervisor is not null before accessing the supervisor_id
        $beneficiary->superviser_id = $superviser ? $superviser->superviser_id : null;

        return $beneficiary;
    }
    public function startRow():int{
        return 2;
    }
}
