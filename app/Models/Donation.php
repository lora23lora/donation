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

    ];
    protected $casts = [
        'date' => 'date',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id','id');
    }
    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'donation_storage', 'donation_id', 'storage_item_id')->withPivot( 'price','amount');
    }
}
