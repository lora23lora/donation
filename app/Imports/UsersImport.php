<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Donation;
use App\Models\Status;
use App\Models\Superviser;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
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

        $statusName = $row['6'];
        $cityName = $row['3'];
        $superviserName = $row['7'];

        $status = Status::where('name', $statusName)->first();
        $city = City::where('city_name', $cityName)->first();
        $superviser = Superviser::where('name', $superviserName)->first();

        $data = [
            'name' => $row['0'],
            'address' => $row['1'],
            'familyMembers' => $row['2'],
            'birthdate' => $row['4'],
            'amount' => $row['5'],
            'Tel1' => $row['8'],
            'Tel2' => $row['9'],
            'note' => $row['10'],
            'active' => $row['11'],
        ];

        // Check if Status, City, and Superviser are found or not
        if ($status) {
            $data['status_id'] = $status->status_id;
        }

        if ($city) {
            $data['city_id'] = $city->city_id;
        }

        if ($superviser) {
            $data['superviser_id'] = $superviser->superviser_id;
        }

        // Create the Donation model instance
        return new Donation($data);
    }
}
