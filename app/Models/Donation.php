<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'amount',
        'Tel1',
        'Tel2',
        'status_id',
        'superviser_id',
        'city_id',
        'user_id',
        'active',
        'note',
        'date'
    ];
    protected $casts = [
        'date' => 'datetime',
        'line_items' => 'array',

    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id','status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function superviser()
    {
        return $this->belongsTo(Superviser::class, 'superviser_id','superviser_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id','city_id');
    }
}
