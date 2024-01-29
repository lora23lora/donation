<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'address',
        'Tel1',
        'Tel2',
        'birthdate',
        'statuses',
        'superviser_id',
        'city_id',
        'user_id',
        'active',
        'familyMembers',
        'file'
    ];

    protected $casts = [
        'status' => 'array',
    ];

    public function superviser()
    {
        return $this->belongsTo(Superviser::class, 'superviser_id','superviser_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id','city_id');
    }
    public function donation()
    {
        return $this->hasMany(Donation::class, 'beneficiary_id','id');
    }
}
