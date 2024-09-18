<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Income extends Model
{
    use HasFactory, HasFlexible;
    protected $fillable = [
        'name',
        'amount',
        'date',
        'note',

    ];
    protected $casts = [
        'date' => 'date',
    ];
}
