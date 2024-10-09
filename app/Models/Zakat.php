<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date',
    ];
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
