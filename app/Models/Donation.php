<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'beneficiary_id',
        'approved',
        'note',
        'line_items',
        'date'
    ];
    protected $casts = [
        'date' => 'datetime',
        'line_items' => 'array',

    ];
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id','id');
    }
    
    public function items()
    {
        return $this->hasMany(Storage::class, 'line_item');
    }

}
