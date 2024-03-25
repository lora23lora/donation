<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Donation extends Model
{
    use HasFactory, HasFlexible;

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


    public function getFlexibleContentAttribute()
    {
        return $this->flexible('line_items');
    }
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

}
