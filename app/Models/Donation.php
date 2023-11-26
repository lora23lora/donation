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
        'user_id',
        'note',
        'date'
    ];

    protected $dates = [
		'date'
	];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
