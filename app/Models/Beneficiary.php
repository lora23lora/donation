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
        'status',
        'superviser_id',
        'city_id',
        'user_id',
        'active',
        'familyMembers',
        'file'
    ];
    
    public function superviser()
    {
        return $this->belongsTo(Superviser::class, 'superviser_id','superviser_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id','city_id');
    }
}
